<template>
    <div class="container-fluid py-10">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div v-if="!item.uuid" class="text-center pt-15">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div v-else>
                    <div class="card shadow-sm border-0" ref="pdfContent">
                        <div class="card-header align-items-center text-center bg-primary text-white">
                            <h4 class="mb-0 text-white">Invoice</h4>
                            <small class="d-block">Order ID: #{{ item.order_id }}</small>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <p class="mb-1"><strong>Nama:</strong> {{ item.pembayarans[0]?.user?.name }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ item.pembayarans[0]?.user?.email }}</p>
                                <p class="mb-1"><strong>No. Telepon:</strong> {{ item.pembayarans[0]?.user?.phone }}</p>
                                <p><strong>Alamat:</strong> {{ item.pembayarans[0]?.user?.alamat }}</p>
                            </div>
                            <div class="table-responsive">
                                <h5 class="text-primary">Detail Pemesanan</h5>
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" scope="col">Produk</th>
                                            <th class="text-center" scope="col">Harga</th>
                                            <th class="text-center" scope="col">Kuantitas</th>
                                            <th class="text-center" scope="col">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr v-for="(pembayaran, index) in item.pembayarans" :key="index">
                                            <td>{{ pembayaran.barang?.nama }}</td>
                                            <td>{{ currency(pembayaran.barang?.harga) }}</td>
                                            <td>{{ pembayaran.kuantitas }}</td>
                                            <td>{{ currency(pembayaran.total_harga) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Ongkir</td>
                                            <td>{{ currency(item.ongkir) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center pt-10">
                                    <h5 class="text-primary">Total: <span class="text-black">{{ currency(hargaAkhir) }}</span></h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light" ref="buttonContainer">
                            <div class="d-flex justify-content-between text-center">
                                <button class="btn btn-secondary btn-sm px-4" onclick="history.back()"><i class="la la-arrow-left"></i>Kembali</button>
                                <button class="btn btn-danger btn-sm px-4" @click="generatePDF">
                                    <i class="la la-file-pdf fs-4"></i>Download Invoice
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { block, unblock, currency } from "@/libs/utils";
import axios from "@/libs/axios";
import { toast } from "vue3-toastify";
import html2pdf from 'html2pdf.js';

interface Pengiriman {
    id: number;
    uuid: string;
    order_id: string;
    ongkir: number;
    status: string;
    pembayarans: {
        id: number;
        uuid: string;
        user_id: BigInteger;
        user: {
            id: BigInteger;
            uuid: string;
            name: string;
            email: string;
            phone: string;
            photo: string;
            password: string;
            role: {
                name: string;
                full_name: string;
            };
        };
        barang_id: BigInteger;
        barang: {
            id: BigInteger;
            uuid: string;
            nama: string;
            deskripsi: string;
            stok: BigInteger;
            kategori_id: BigInteger;
            kategori: {
                id: BigInteger;
                uuid: string;
                nama: string;
            };
            harga: BigInteger;
            barang_images: {
                id: BigInteger;
                uuid: string;
                barang_id: BigInteger;
                image: string;
            };
        };
        kuantitas: string;
        total_harga: string;
        status: string;
    }
}

export default defineComponent({
    setup() {
        const item = ref<Pengiriman>({} as Pengiriman);
        const route = useRoute();
        const router = useRouter();
        const pdfContent = ref(null);
        const buttonContainer = ref(null);

        const hargaAkhir = computed(() => {
            const totalPembayaran = item.value.pembayarans?.reduce((acc, pembayaran) => {
                return acc + parseFloat(pembayaran.total_harga);
            }, 0) || 0;

            return totalPembayaran + (item.value.ongkir || 0);
        });

        return {
            item,
            route,
            router,
            currency,
            pdfContent,
            buttonContainer,
            hargaAkhir,
        }
    },
    methods: {
        data() {
            block(this.$el)
            axios.get(`/landing/toko/detail/${this.route.params.uuid}/invoice`).then(response => {
                this.item = response.data.item
            }).catch(error => {
                toast.error(error.response.data.message)
            }).finally(() => {
                unblock(this.$el)
            });
        },
        async generatePDF() {
            try {
                block(this.$el);
                
                const buttonDiv = this.$refs.buttonContainer as HTMLElement;
                
                const originalDisplay = buttonDiv.style.display;
                
                buttonDiv.style.display = 'none';
                
                const pdfElement = this.$refs.pdfContent;
                
                const opt = {
                    margin: 1,
                    filename: `Invoice-${this.item.uuid}.pdf`,
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { 
                        scale: 2,
                        logging: true,
                        backgroundColor: '#ffffff'
                    },
                    jsPDF: { unit: 'cm', format: 'a4', orientation: 'portrait' }
                };

                await html2pdf().set(opt).from(pdfElement).save();
                
                buttonDiv.style.display = originalDisplay;
                
                toast.success('Invoice berhasil diunduh');
            } catch (error) {
                console.error('Error generating PDF:', error);
                toast.error('Gagal mengunduh invoice');
                
                if (this.$refs.buttonContainer) {
                    (this.$refs.buttonContainer as HTMLElement).style.display = '';
                }
            } finally {
                unblock(this.$el);
            }
        }
    },
    mounted() {
        this.data();
    }
})
</script>