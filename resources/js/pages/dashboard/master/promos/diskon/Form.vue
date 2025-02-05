<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema" id="form">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? "Edit" : "Tambah" }} Diskon Barang</h2>
            <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Barang</label>
                        <Field type="hidden" v-model="formData.barang_id" name="barang_id" readonly />
                        <select2 placeholder="Pilih Barang" class="form-select-solid" :options="barangs"
                            name="barang_id" v-model="formData.barang_id">
                        </select2>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="barang_id" />
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
import { useBarang } from '@/services';
import { usePromo } from '@/services';

interface FormData {
    promo_id: number;
    barang_id: number;
    potongan_harga: number;
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
            promo_id: Yup.number().required('Promo harus diisi'),
            barang_id: Yup.number().required('Barang harus diisi'),
            potongan_harga: Yup.string().required('Harga harus diisi'),
        })

        const barang = useBarang()
        const barangs = computed(() => barang.data.value?.map(item => ({
            id: item.id,
            text: item.nama
        })))
        const promo = usePromo()
        const promos = computed(() => promo.data.value?.map(item => ({
            id: item.id,
            text: item.nama
        })))


        return {
            formData,
            formSchema,
            barangs,
            promos,
        }
    },
    methods: {
        show() {
            block(this.$el)

            axios.get(`/master/diskon/${this.selected}/show`)
                .then(res => {
                    this.formData = res.data.data
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

            const formData = new FormData(document.querySelector('#form'))

            axios.post(this.selected ? `/master/diskon/${this.selected}/update` : `/master/diskon/store`, formData)
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