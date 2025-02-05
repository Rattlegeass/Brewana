<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema" id="form">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? "Edit" : "Tambah" }} Barang</h2>
            <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
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
                    <div class="fv-row mb-">
                        <label class="form-label fw-bold text-dark fs-6 required">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text border-0">Rp</span>
                            <Field class="form-control form-control-lg form-control-solid " type="text" name="harga" autocomplete="off" 
                                v-model="formData.harga"/>
                        </div>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="harga" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
                <div class="col-md-3">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Stok</label>
                        <Field class="form-control form-control-lg form-control-solid" type="number" name="stok"
                            autocomplete="off" v-model="formData.stok" pattern="^\d+(,\d{1,2})?$" step="any"/>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="stok" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Kategori</label>
                        <Field type="hidden" v-model="formData.kategori_id" name="kategori_id" readonly />
                        <select2 placeholder="Pilih Kategori" class="form-select-solid" :options="kategoris"
                            name="kategori_id" v-model="formData.kategori_id">
                        </select2>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="kategori_id" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Promo</label>
                        <Field type="hidden" v-model="formData.promo_id" name="promo_id" readonly />
                        <select2 placeholder="Pilih Promo" class="form-select-solid" :options="promos"
                            name="promo_id" v-model="formData.promo_id">
                        </select2>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="promo_id" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold fs-6">
                            Image
                        </label>
                        <span class="required"> (max: 3)</span>
                        <file-upload v-bind:files="barang_images" :accepted-file-types="fileTypes" required v-on:updatefiles="onUpdateFiles" :allowMultiple="true" :maxFiles="3"></file-upload>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="image" />
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
import { computed, defineComponent, ref } from "vue";
import * as Yup from "yup";
import axios from "@/libs/axios";
import { toast } from "vue3-toastify";
import { useKategori, usePromo } from '@/services';

interface FormData {
    nama: string;
    deskripsi: string | null;
    stok: number;
    harga: string;
    kategori_id: number;
    promo_id: number;
    barang_images: [
        {
            image: string;
        }
    ] 
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
            stok: Yup.string().required('Stok harus diisi'),
            kategori_id: Yup.number().required('Kategori harus diisi'),
            harga: Yup.string().required('Harga harus diisi'),
        })

        const kategori = useKategori()
        const kategoris = computed(() => kategori.data.value?.map(item => ({
            id: item.id,
            text: item.nama
        })))

        const promo = usePromo()
        const promos = computed(() => promo.data.value?.map(item => ({
            id: item.id,
            text: item.nama
        })))

        const barang_images = ref<Array<File | String>>([])
        const fileTypes = ref(['image/jpeg', 'image/png'])

        const onUpdateFiles = (newFiles: Array<File | String>) => {
            barang_images.value = newFiles
        }

        return {
            formData,
            formSchema,
            kategoris,
            promos,
            barang_images,
            fileTypes,
            onUpdateFiles,
        }
    },
    methods: {
        show() {
            block(this.$el)

            axios.get(`/master/barang/${this.selected}/show`)
                .then(res => {
                    this.formData = res.data.data
                    this.barang_images = this.formData.barang_images.map(barang_image => `/storage/${barang_image.image}`)
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

            if (this.barang_images.length < 0) {
                toast.error('Image tidak boleh kosong!')
            }

            const formData = new FormData(document.querySelector('#form'))
            this.barang_images.forEach(barang_image => {
                formData.append("image[]", barang_image.file);
            })

            axios.post(this.selected ? `/master/barang/${this.selected}/update` : `/master/barang/store`, formData)
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