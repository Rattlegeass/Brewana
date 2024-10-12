<template>
    <div class="w-lg-500px w-100">
        <div class="text-center mb-10">
            <router-link to="/">
                <img :src="setting?.logo" :alt="setting?.app" class="w-150px mb-8">
            </router-link>

            <h1 class="mb-3">
                Verify OTP
            </h1>
        </div>

        <div class="border-bottom border-gray-300 w-100 mt-5 mb-10"></div>

        <!-- <form @submit.prevent="verifyOtp"> -->
        <VForm class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework pb-4 pt-4" @submit="verifyOtp"
            id="form-verifikasi-otp" ref="formRef"
        >
            <div class="card-body d-flex justify-content-center gap-10">
                <input v-for="(digit, index) in otpCode" 
                    :key="index" 
                    v-model="otpCode[index]" 
                    type="text" 
                    maxlength="1" 
                    @input="focusNext($event, index)"
                    id="index"
                    class="text-center fs-3" 
                    style="width: 40px; height: 50px"
                />
            </div>
            <div class="card-footer mt-10 d-flex justify-content-center">
                <button type="submit" ref="submitButton" class="btn btn-lg btn-primary w-75 mb-5">
                    Register
                </button>
            </div>
        </VForm>
        <!-- </form> -->

        <div class="border-bottom border-gray-300 w-100 mt-5 mb-10"></div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import { useSetting } from "@/services";
import { toast } from "vue3-toastify"

export default defineComponent({
data() {
    return {
        otpCode: ['', '', '', '', '', ''], // Untuk 6 digit OTP
    };
},
setup() {
    const route = useRoute();
    const router = useRouter();
    const { data: setting = {} } = useSetting()
    return { 
        setting, 
        route, 
        router 
    };
},
methods: {
    verifyOtp() {
        const otp = this.otpCode.join('');
        const email = this.$route.params.email;

            axios.post('auth/verify-otp', { email, otp_code: otp})
                .then(res => {
                    toast.success(res.data.message);
                    this.router.push({ name: 'sign-in' });
                })
                .catch (err => {
                    console.error(err);
                    toast.error('Error during OTP verification');
                })
    },
    focusNext(event: Event, index: number) {
        const input = event.target as HTMLInputElement;
        if (input.value.length === 1 && index < this.otpCode.length - 1) {
            const nextInput = document.querySelectorAll<HTMLInputElement>('#index')[index + 1];
            if (nextInput) nextInput.focus();
        }
    }
},
});
</script>