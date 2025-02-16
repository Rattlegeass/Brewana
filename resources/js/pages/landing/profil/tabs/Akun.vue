<template>
    <div class="card mb-15">
        <div class="card-body">
            <VForm @submit="update" id="form-akun" :validation-schema="formSchema">
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fw-bold">Foto</label>
                    <!--end::Label-->
        
                    <!--begin::Input-->
                    <file-upload v-bind:files="files" :accepted-file-types="fileTypes"
                        v-on:updatefiles="onUpdateFiles"></file-upload>
                    <!--end::Input-->
                    <div class="fv-plugins-message-container">
                        <div class="fv-help-block">
                            <ErrorMessage name="photo" />
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
        
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fw-bold required">Nama</label>
                    <!--end::Label-->
        
                    <!--begin::Input-->
                    <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="name"
                        autocomplete="off" v-model="formData.name"/>
                    <!--end::Input-->
                    <div class="fv-plugins-message-container">
                        <div class="fv-help-block">
                            <ErrorMessage name="name" />
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
        
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fw-bold required">Email</label>
                    <!--end::Label-->
        
                    <!--begin::Input-->
                    <Field tabindex="2" class="form-control form-control-lg form-control-solid" type="text" name="email"
                        autocomplete="off" readonly v-model="formData.email"/>
                    <!--end::Input-->
                    <div class="fv-plugins-message-container">
                        <div class="fv-help-block">
                            <ErrorMessage name="email" />
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
        
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fw-bold required">No. Telepon</label>
                    <!--end::Label-->
        
                    <!--begin::Input-->
                    <Field tabindex="3" class="form-control form-control-lg form-control-solid" type="text" name="phone"
                        autocomplete="off" readonly v-model="formData.phone"/>
                    <!--end::Input-->
                    <div class="fv-plugins-message-container">
                        <div class="fv-help-block">
                            <ErrorMessage name="phone" />
                        </div>
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fw-bold required">Alamat</label>
                    <!--end::Label-->
        
                    <!--begin::Input-->
                    <Field tabindex="4" class="form-control form-control-lg form-control-solid" type="text" name="alamat"
                        autocomplete="off" v-model="formData.alamat"/>
                    <!--end::Input-->
                    <div class="fv-plugins-message-container">
                        <div class="fv-help-block">
                            <ErrorMessage name="alamat" />
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
        
                <!--begin::Actions-->
                <div class="text-center">
                    <!--begin::Submit button-->
                    <button tabindex="5" type="submit" ref="submitButton" class="btn btn-lg btn-primary w-100 mb-5">
                        <span class="indicator-label">Simpan</span>
        
                        <span class="indicator-progress">
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Submit button-->
                </div>
                <!--end::Actions-->
            </VForm>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useAuthStore } from '@/stores/auth';
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { block, blockBtn, unblock, unblockBtn } from '@/libs/utils';
import { toast } from 'vue3-toastify';

interface FormData {
    name: string;
    photo: string;
    email: string;
    phone: string;
    alamat: string;
}

export default defineComponent({
    setup() {
        const formData = ref<FormData>({} as FormData)

        const { user, setAuth } = useAuthStore()
        const files = ref<Array<File | String>>([])
        const fileTypes = ref(['image/jpeg', 'image/png'])
        const onUpdateFiles = (newFiles: Array<File | String>) => {
            files.value = newFiles
        }

        const formSchema = Yup.object().shape({
            // name: Yup.string().required("Nama harus diisi"),
        });

        return {
            formData,
            user,
            files,
            fileTypes,
            onUpdateFiles,
            formSchema,
            setAuth,
        }
    },
    methods: {
        data() {
            axios.get(`/landing/profil/${this.user?.uuid}/get`).then(response => {
                this.formData = response.data.data
                this.files = response.data.data.photo ? ["/storage/" + response.data.data.photo] : []
            }).catch(error => {
                // toast.error(error.response.data.message)
                console.log(error.response.data.message)
            })
        },
        update() {
            block(this.$el)
            const formData = new FormData(document.querySelector('#form-akun'))
            if (this.files.length > 0) {
                formData.append("foto", this.files[0].file as File)
            } else {
                formData.append("foto", '')
            }
            
            axios.post(`/landing/profil/${this.user.uuid}/update`, formData).then(() => {
                toast.success('Data berhasil disimpan')
            }).catch(err => {
                toast.error(err.response.data.message)
            }).finally(() => {
                unblock(this.$el)
            });
        },
    },
    mounted() {
        this.data();
    }
})
</script>
