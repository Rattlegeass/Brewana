<template>
    <div class="w-lg-500px w-100">
        <div class="text-center mb-10">
            <router-link to="/">
                <img :src="setting?.logo" :alt="setting?.app" class="w-150px mb-8">
            </router-link>

            <h1>
                Reset Sandi <span class="text-primary">{{ setting?.app }}</span>
            </h1>
        </div>

        <div class="border-bottom border-gray-300 w-100 mt-5 mb-10"></div>

        <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework pb-4 pt-4" @submit.prevent="resetPassword">
            <div class="card-body">
                <div class="row">
                    <div class="fv-row mb-2">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold fs-6">
                                Password
                            </label>
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                name="password" autocomplete="off" v-model="password"
                                placeholder="Masukkan Password" required/>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="fv-row mb-2">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold fs-6">
                                Konfirmasi Password
                            </label>
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                name="password_confirmation" autocomplete="off" v-model="password_confirmation"
                                placeholder="Konfirmasi Password" required/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer mt-2 d-flex">
                <button type="submit" ref="submit" class="btn btn-lg btn-primary w-100 mb-5">
                    Reset Password
                </button>
            </div>

        </form>
    </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { useSetting } from "@/services";
import { toast } from 'vue3-toastify';
import { block, unblock } from '@/libs/utils';
import axios from '@/libs/axios';
import { useRoute, useRouter } from 'vue-router';

export default defineComponent({
    data() {
        return {
            password: '',
            password_confirmation: '',
        };
    },
    setup() {
        const { data: setting = {} } = useSetting()
        const route = useRoute()
        const router = useRouter()

        return {
            setting,
            route,
            router
        }
    },
    methods: {
        resetPassword() {
            block(this.$el)
            axios.post('/auth/reset-password', {
                token: this.route.params.token,
                email: this.route.query.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            }).then(response => {
                toast.success(response.data.message);
                this.router.push({ name: 'sign-in' });
            }).catch(error => {
                console.log(error.response.data.message);
                toast.error(error.response.data.errors.email[0]);
            }).finally(() => unblock(this.$el));
        },
    }
})
</script>