<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";
import * as Yup from "yup";
import axios from "@/libs/axios";
import { toast } from "vue3-toastify"
import { blockBtn, unblockBtn } from "@/libs/utils"
import { useSetting } from "@/services";

export default defineComponent({
    data() {
        return {
            user: {
                name: '',
                email: '',
                phone: '',
                alamat: '',
                password: '',
                password_confirmation: '',
            },
        }
    },
    setup() {
        const { data: setting = {} } = useSetting()
        const store = useAuthStore();
        const router = useRouter();

        const submitButton = ref(null);

        const register = Yup.object().shape({
            name: Yup.string().required("Please enter a Name").label("Name"),
            email: Yup.string().email('Invalid Email').required("Please enter Email").label("Email"),
            password: Yup.string().min(8, 'The password must consist of a minimum of 8 characters').required('Please enter the password').label("Password"),
            password_confirmation: Yup.string().oneOf([Yup.ref("password")],"Confirmation Password must be the same").required("Password confirmation is required").label("Confirm Password"),
            phone: Yup.string().matches(/^08[0-9]\d{8,11}$/, "Invalid Phone Number").required("Please fill in the column").label("Phone")
        });

        return {
            register,
            submitButton,
            getAssetPath,
            store, 
            router,
            setting
        };
    },
    methods: {
        submit() {
            blockBtn(this.submitButton);

                axios.post('auth/register', this.user)
                    .then(res => {
                        toast.success(res.data.message);
                        this.router.push({ name: 'verify-otp', params: { email: this.user.email } });
                    })
                    .catch(err => {
                        console.error(err.response.data.errors);
                        toast.error('Registration failed. Please try again.');
                    })

            unblockBtn(this.submitButton);
        },
        togglePassword() {
            const type = document.querySelector("[name=password]").type;

            if (type === 'password') {
                document.querySelector("[name=password]").type = 'text';
                document.querySelector("[name=password_confirmation]").type = 'text';
            } else {
                document.querySelector("[name=password]").type = 'password';
                document.querySelector("[name=password_confirmation]").type = 'password';
            }

        }
    }
})
</script>

<template>
    <div class="w-lg-500px w-100">
        <div class="text-center mb-10">
            <router-link to="/">
                <img :src="setting?.logo" :alt="setting?.app" class="w-150px mb-8">
            </router-link>

            <h1>
                Register Akun <span class="text-primary">{{ setting?.app }}</span>
            </h1>
        </div>

        <div class="border-bottom border-gray-300 w-100 mt-5 mb-10"></div>

        <VForm class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework pb-4 pt-4" @submit="submit"
            :validation-schema="register" id="form-user" ref="formRef">
            <div class="card-body">
                <div class="row">
                    <div class="fv-row mb-2">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold fs-6">
                                Nama
                            </label>
                            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text"
                                name="name" autocomplete="off" v-model="user.name" placeholder="Masukkan Nama" />
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">
                                    <ErrorMessage name="name" />
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="fv-row mb-2">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold fs-6">
                                Email
                            </label>
                            <Field tabindex="2" class="form-control form-control-lg form-control-solid" type="text"
                                name="email" autocomplete="off" v-model="user.email" placeholder="Masukkan Email" />
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">
                                    <ErrorMessage name="email" />
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="fv-row mb-2">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold fs-6">
                                Nomor Telepon
                            </label>
                            <Field tabindex="3" class="form-control form-control-lg form-control-solid" type="text"
                                name="phone" autocomplete="off" v-model="user.phone"
                                placeholder="Masukkan Nomor Telepon" />
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">
                                    <ErrorMessage name="phone" />
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="fv-row mb-2">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold fs-6">
                                Alamat
                            </label>
                            <Field tabindex="4" class="form-control form-control-lg form-control-solid" type="text"
                                name="alamat" autocomplete="off" v-model="user.alamat" placeholder="Masukkan Alamat" />
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">
                                    <ErrorMessage name="alamat" />
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="fv-row mb-2">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold fs-6">
                                Password
                            </label>
                            <Field tabindex="5" class="form-control form-control-lg form-control-solid" type="password"
                                name="password" autocomplete="off" v-model="user.password"
                                placeholder="Masukkan Password" />
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">
                                    <ErrorMessage name="password" />
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="fv-row mb-2">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold fs-6">
                                Konfirmasi Password
                            </label>
                            <Field tabindex="6" class="form-control form-control-lg form-control-solid" type="password"
                                name="password_confirmation" autocomplete="off" v-model="user.password_confirmation"
                                placeholder="Konfirmasi Password" />
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">
                                    <ErrorMessage name="password_confirmation" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-9">
                        <!--begin::Input group-->
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" @click="togglePassword" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Tunjukkan Password
                        </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer mt-2 d-flex">
                <button tabindex="6" type="submit" ref="submitButton" class="btn btn-lg btn-primary w-100 mb-5">
                    Register
                </button>
            </div>

        </VForm>

        <div class="border-bottom border-gray-300 w-100 mt-5 mb-10"></div>

        <div class="text-gray-400 fw-semobold fs-4 text-center mt-10">
            {{ $t('Sudah memiliki akun?') }}

            <router-link to="/sign-in" class="link-primary fw-bold">
                {{ $t('Masuk Sekarang!') }}
            </router-link>
        </div>
    </div>
</template>
