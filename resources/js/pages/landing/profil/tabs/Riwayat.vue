<template>
    <div class="card p-7" v-if="items.data?.length > 0">
        <div class="card shadow-md mb-15" v-for="(item, index) in items.data" :key="index">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-3 d-flex flex-column justify-content-center align-items-center">
                        <div class="overflow-hidden rounded shadow-sm" style="height: 100px; width: 125px;">
                            <img :src="`/storage/${item.barang?.barang_images[0]?.image}`" alt="Gambar Vertikal" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>

                    <div class="col-12 col-md-9 d-flex flex-column justify-content-center">
                        <div class="d-flex flex-wrap gap-2">
                            <div class="badge badge-success" v-if="item.status === 'success'">Berhasil</div>
                            <div class="badge badge-warning" v-if="item.status === 'pending'">Menunggu</div>
                            <div class="badge badge-danger" v-if="item.status === 'failed'">Gagal</div>
                            <div class="badge badge-info" v-if="item.pengiriman?.status === 'dikemas'">Dikemas</div>
                            <div class="badge badge-primary" v-if="item.pengiriman?.status === 'dikirim'">Dikirim</div>
                            <div class="badge badge-success" v-if="item.pengiriman?.status === 'diterima'">Diterima</div>
                            <div class="badge badge-danger" v-if="item.status === 'refund'">Refund</div>
                        </div>
                        <h2 class="fw-bold mb-4">{{ item.barang?.nama }}</h2>
                        <p class="text-muted mb-6">{{ item.barang?.deskripsi }}</p>
                        <h4 class="text-dark fw-bold">Total {{ item.kuantitas }} produk: <span class="text-primary">{{ currency(item.barang?.harga) }}</span></h4>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center gap-2" v-if="item.status === 'success'">
                <h3>Tanggal Pemesanan: <span class="text-warning">{{ formatTanggal(item.created_at) }}</span></h3>
                <div class="btn btn-sm btn-primary" @click="router.push(`/landing/invoice/${item.pengiriman?.uuid}`)">Cek Invoice</div>
            </div>
        </div>
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination">
                <li v-for="(link, index) in items.links" :key="index" :class="['page-item', { disabled: !link.url, active: link.active }]">
                    <a class="page-link" v-if="link.url" href="#" @click.prevent="data(link.url)">
                        <span v-html="link.label"></span>
                    </a>
                    <span v-else class="page-link" v-html="link.label"></span>
                </li>
            </ul>
        </nav>
    </div>
    <div class="text-center pt-15" v-else>
        <h3>Barang tidak ditemukan!</h3>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { useRouter } from 'vue-router';
import { currency, block, unblock } from "@/libs/utils";
import axios from "@/libs/axios";
import { toast } from "vue3-toastify";

interface Pembayaran {
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
    order_id: string;
    pengiriman_id: BigInteger;
    pengiriman: {
        id: BigInteger;
        uuid: string;
        order_id: string;
        ongkir: number;
        status: string;
    };
}

export default defineComponent({
    setup() {
        const items = ref<Pembayaran>({} as Pembayaran);
        const router = useRouter();

        return {
            items,
            router,
            currency,
        }
    },
    methods: {
        data(url = 'landing/profil/riwayat') {
            block(this.$el)
            axios.post(url).then(response => {
                this.items = response.data.items
            }).catch(error => {
                toast.error(error.response.data.message)
            }).finally(() => {
                unblock(this.$el)
            });
        },
        formatTanggal(data) {
            if (!data) return '-';
    
            const date = new Date(data);
            return new Intl.DateTimeFormat('id-ID', {
                day: '2-digit', month: 'long', year: 'numeric'
            }).format(date);
        }
    },
    mounted() {
        this.data();
    }
})
</script>
