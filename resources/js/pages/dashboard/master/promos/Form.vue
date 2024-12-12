<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema" id="form">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? "Edit" : "Tambah" }} Promo</h2>
            <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold fs-6">
                            Image
                        </label>
                        <file-upload :files="image" :accepted-file-types="fileTypes" required v-on:updatefiles="onUpdateFiles"></file-upload>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="image" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Nama</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="nama"
                            autocomplete="off" v-model="formData.nama"/>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="nama" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Deskripsi</label>
                        <Field name="deskripsi" autocomplete="off" v-model="formData.deskripsi">
                        <textarea class="form-control form-control-lg form-control-solid" name="deskripsi" rows="2"
                            v-model="formData.deskripsi"></textarea>
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="deskripsi" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold fs-6 required">Periode Awal</label>
                        <date-picker name="periode_awal" v-model="formData.periode_awal" placeholder="Pilih P. Awal"/>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="periode_awal" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold fs-6 required">Periode Akhir</label>
                        <date-picker name="periode_akhir" v-model="formData.periode_akhir" placeholder="Pilih P. Akhir"/>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="periode_akhir" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex">
            <button type="submit" class="btn btn-primary btn-sm ms-auto">
                Simpan
            </button>
        </div>
    </VForm>
</template>

<script lang="ts">
import { block, unblock } from "@/libs/utils";
import { defineComponent, ref } from "vue";
import * as Yup from "yup";
import axios from "@/libs/axios";
import { toast } from "vue3-toastify";

interface FormData {
    nama: string;
    deskripsi: string | null;
    image: string;
    periode_awal: string;
    periode_akhir: string;
}

export default defineComponent({
    props: {
        selected: {
            type: String,
            default: null
        },
    },
    emits: ['close', 'refresh'],
    setup() {
        const formData = ref<FormData>({} as FormData)

        const formSchema = Yup.object().shape({
            nama: Yup.string().required('Nama harus diisi'),
        })

        const image = ref<Array<File | String>>([])
        const fileTypes = ref(['image/jpeg', 'image/png', 'image/jpg'])
        const onUpdateFiles = (newFiles: Array<File | String>) => {
            image.value = newFiles
        }

        return {
            formData,
            formSchema,
            image,
            fileTypes,
            onUpdateFiles,
        }
    },
    methods: {
        show() {
            block(this.$el)

            axios.get(`/master/promo/${this.selected}/show`)
                .then(res => {
                    this.formData = res.data.data
                    console.log(res.data.data)
                    this.image = res.data.data.image ? ["/storage/" + res.data.data.image] : []
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        },
        submit() {
            block(this.$el)

            if (this.image.length < 0) {
                toast.error('Image tidak boleh kosong!')
                unblock(this.$el)
            }

            const formData = new FormData(document.querySelector('#form'))
            if (this.image.length > 0) {
                formData.append("image", this.image[0].file as File)
            }

            axios.post(this.selected ? `/master/promo/${this.selected}/update` : `/master/promo/store`, formData)
                .then(() => {
                    this.$emit('close')
                    this.$emit('refresh')
                    toast.success('Data berhasil disimpan')
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        }
    },
    mounted() {
        if (this.selected) {
            this.show()
        }
    },
    watch: {
        selected() {
            if (this.selected) {
                this.show()
            }
        }
    }
})
</script>