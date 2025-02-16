<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Mail\SendOtpEmail;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function me()
    {
        return response()->json([
            'user' => auth()->user()
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json([
                'status' => false,
                'message' => 'Email / Password salah!'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'user' => auth()->user(),
            'token' => $token
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:8|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'alamat' => 'required|string|max:255',
        ]);

        $otp = rand(100000, 999999);

        Cache::put('user_' . $request->email, [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'otp_code' => $otp
        ], now()->addMinutes(2));

        Mail::to($request->email)->send(new SendOtpEmail($request->name, $otp));

        return response()->json([
            'message' => 'OTP sent to your email. Please verify.',
            'email' => $request->email
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|numeric',
        ]);

        $cachedUser = Cache::get('user_' . $request->email);

        if (!$cachedUser) {
            return response()->json(['message' => 'OTP expired or invalid.'], 400);
        }

        if ($cachedUser['otp_code'] != $request->otp_code) {
            return response()->json(['message' => 'Invalid OTP code.'], 400);
        }

        $validator['role_id'] = 2;

        $user = User::create([
            'name' => $cachedUser['name'],
            'email' => $cachedUser['email'],
            'phone' => $cachedUser['phone'],
            'password' => $cachedUser['password'],
        ]);

        $role = Role::findById($validator['role_id']);
        $user->assignRole($role);

        Cache::forget('user_' . $request->email);

        return response()->json(['message' => 'OTP verified successfully.']);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'), function ($user, $token) {
            $resetUrl = url("/reset-password/{$token}/?email=" . urlencode($user->email));
            Mail::to($user->email)->send(new ResetPasswordEmail($resetUrl));
        });

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent']);
        }

        throw ValidationException::withMessages(['email' => __($status)]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password has been reset']);
        }

        throw ValidationException::withMessages(['email' => __($status)]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['success' => true]);
    }
}
