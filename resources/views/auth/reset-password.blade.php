<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lupa Sandiri - Verifikasi BREWANA</title>
</head>

<body style="color: #252a61; text-align: center; background-color: lightcyan; font-family: 'Poppins', sans-serif; padding: 2rem 1rem;">
    <div style="max-width: 480px; margin: 0 auto">
        <h1>BREWANA - Kopi Kita</h1>
        <div style="border-top: 8px solid #252a61; background-color: #fff; padding: 2rem 1.5rem; border-radius: 0.5rem;">
            <div>
                <p>Kami menerima permintaan untuk mereset kata sandi Anda. Klik tombol di bawah ini untuk <strong>mereset kata sandi</strong> Anda:</p>
                <div style="padding: 0.75rem 1.5rem; background-color: lightcyan; border-radius: 0.5rem; display: inline-block; margin: 1.25rem 0; overflow: hidden;">
                    <a href="{{ $resetUrl }}" 
                        style="color: black; font-weight: bold; padding: 10px; text-decoration: none;">
                        Reset Password
                    </a>
                </div>
                <p>
                    Jika bukan anda yang melakukan permintaan ini, <strong>abaikan</strong> email ini.
                </p>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <div>
                <small>{{ date('Y') }} ©</small>
                <small>BREWANA - Kopi Kita</small>
            </div>
        </div>
    </div>
</body>

</html>
