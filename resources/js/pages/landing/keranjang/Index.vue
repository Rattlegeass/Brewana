<template>
    <div class="container-fluid p-10 g-5" id="keranjang">
        <div class="search-container mb-5 shadow-lg">
            <div class="input-group search-bar">
                <span class="input-group-text bg-white border-end-0">
                    <i class="la la-search text-muted fs-4"></i>
                </span>
                <input 
                    type="text" 
                    class="form-control border-start-0 bg-white" 
                    placeholder="Cari barang..." 
                    v-model="search"
                    @input="data()"
                />
            </div>
        </div>
        <div v-if="items.data?.length > 0">
            <div class="card mb-5 shadow-lg" v-for="(item, index) in items.data" :key="index">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-3 col-sm-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="overflow-hidden rounded shadow-sm" style="height: 150px; width: 175px;">
                                <img :src="`/storage/${item.barang?.barang_images[0]?.image}`" alt="Gambar Vertikal" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                        </div>

                        <div class="col-12 col-md-7 col-sm-6 d-flex flex-column justify-content-center">
                            <h3 class="card-title fw-bold">{{ item.barang?.nama }}</h3>
                            <p class="card-text text-muted">Kategori: <span class="text-dark">{{ item.barang?.kategori?.nama }}</span></p>
                            <p class="card-text">{{ item.barang?.deskripsi }}</p>
                            <h4 class="text-primary fw-bold mb-4">
                                <span v-if="item.barang?.harga_diskon" class="text-decoration-line-through opacity-25 me-2">{{ currency(item.barang?.harga) }}</span>
                                <span v-if="item.barang?.harga_diskon">{{ currency(item.barang?.harga_diskon) }}</span>
                                <span v-if="item.barang?.harga_diskon == null">{{ currency(item.barang?.harga) }}</span>
                            </h4>
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-success me-2 text-white" v-if="item.barang?.stok > 0">Stok Tersedia</span>
                                <span class="badge bg-danger me-2 text-white" v-if="item.barang?.stok == 0">Stok Habis</span>
                                <small class="text-muted">Tersisa {{ item.barang?.stok }} unit</small>
                            </div>
                        </div>

                        <div class="col-12 col-md-2 col-sm-12 d-flex justify-content-end align-items-start">
                            <button class="btn btn-sm btn-danger ms-1" @click="deleteItem(`/landing/keranjang/${item.uuid}/hapus-item`)"><i class="la la-times"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row d-flex align-items-center g-3">
                        <div class="col-12 col-md-1 col-sm-1 d-flex justify-content-center align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" :value="item.barang.id" v-model="selected" @change="console.log(selected)">
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-11 col-sm-11 d-flex flex-column">
                            <h2 class="fw-bold text-dark">Total Harga: <span class="text-success">{{ currency(item.total_harga) }}</span></h2>
                            <div class="d-flex align-items-center gap-2">
                                <button v-if="item.barang?.stok > 0" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" @click="aturKuantitas(item.uuid, 'kurang')">
                                    <i class="la la-minus ms-1"></i>
                                </button>
                                <button v-if="item.barang?.stok == 0" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center disabled" style="width: 32px; height: 32px;" @click="aturKuantitas(item.uuid, 'kurang')">
                                    <i class="la la-minus ms-1"></i>
                                </button>
                                <div class="border border-dark-subtle px-3 py-1 rounded bg-light text-center">
                                    <span class="fw-bold">{{ item.kuantitas }}</span>
                                </div>
                                <button v-if="item.barang?.stok > 0" class="btn btn-sm btn-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" @click="aturKuantitas(item.uuid, 'tambah')" :disabled="item.barang?.stok == item.kuantitas">
                                    <i class="la la-plus ms-1"></i>
                                </button>
                                <button v-if="item.barang?.stok == 0" class="btn btn-sm btn-primary d-flex align-items-center justify-content-center disabled" style="width: 32px; height: 32px;" @click="aturKuantitas(item.uuid, 'tambah')">
                                    <i class="la la-plus ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav aria-label="Page navigation" class="mt-4 mb-5">
                <ul class="pagination">
                    <li v-for="(link, index) in items.links" :key="index" :class="['page-item', { disabled: !link.url, active: link.active }]">
                        <a class="page-link" v-if="link.url" href="#" @click.prevent="data(link.url)">
                            <span v-html="link.label"></span>
                        </a>
                        <span v-else class="page-link" v-html="link.label"></span>
                    </li>
                </ul>
            </nav>
            <div class="fixed-bottom bg-white shadow-lg border-top p-3">
                <div class="container p-8">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-2">
                            <div class="form-check d-flex justify-content-center align-items-center">
                                <input 
                                    class="form-check-input me-2" 
                                    type="checkbox" 
                                    id="selectAll" 
                                    v-model="isAllSelected"
                                    @change="toggleSelectAll"
                                />
                                <label class="form-check-label" for="selectAll">
                                    Pilih Semua ({{ selected.length }}/{{ items.data.length }})
                                </label>
                            </div>
                        </div>

                        <div class="col-12 col-md-8 text-center">
                            <h4 class="fw-bold text-dark m-0">
                                Total Harga: <span class="text-success">{{ currency(totalHarga) }}</span>
                            </h4>
                        </div>

                        <div class="col-12 col-md-2 text-md-end text-center mt-2 mt-md-0">
                            <button class="btn btn-primary px-4 py-2" @click="checkout()">
                                Checkout ({{ selected.length }})
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="text-center pt-15" v-else>
            <h3>Barang tidak ditemukan!</h3>
        </div>
    </div>
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue';
import axios from "@/libs/axios";
import { toast } from "vue3-toastify";
import Swal from "sweetalert2/dist/sweetalert2.js";
import { currency, block, unblock } from "@/libs/utils";
import { useDelete } from "@/libs/hooks";
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

interface Keranjang {
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
        harga: BigInteger;
        kategori_id: BigInteger;
        kategori: {
            id: BigInteger;
            uuid: string;
            nama: string;
        };
        promo_id: BigInteger;
        promo: {
            id: BigInteger;
            uuid: string;
            nama: string;
            deskripsi: string;
            image: string;
            periode_awal: string;
            periode_akhir: string;
            potongan_harga: BigInteger;
        }
        barang_images: {
            id: BigInteger;
            uuid: string;
            barang_id: BigInteger;
            image: string;
        };
    };
    kuantitas: string;
}

export default defineComponent({
    setup() {
        const auth = useAuthStore();
        const router = useRouter();
        const items = ref<Keranjang>({} as Keranjang);
        const selected = ref([])
        const search = ref('');
        const { delete: deleteItem } = useDelete({
            onSuccess: () => location.reload()
        })

        return {
            auth,
            router,
            items,
            selected,
            search,
            currency,
            deleteItem,
        }
    },
    methods: {
        data(url = '/landing/keranjang/get') {
            block(this.$el)
            axios.post(url, {
                search: this.search
            }).then(response => {
                this.items = response.data.items
            }).catch(error => {
                toast.error(error.response.data.message)
            }).finally(() => {
                unblock(this.$el)
            });
        },
        aturKuantitas(uuid, trait) {
            const item = this.items.data.find(item => item.uuid === uuid);
            if (!item) {
                return toast.error('Item tidak ditemukan!');
            }

            const kuantitas = Number(item.kuantitas);
            const stok = Number(item.barang?.stok);

            if (trait === 'kurang' && kuantitas === 1) {
                return this.deleteItem(`/landing/keranjang/${uuid}/hapus-item`)
            } else if (trait === 'tambah' && kuantitas >= stok) {
                return toast.error('Telah Mencapai Batas Stok!');
            }

            block(this.$el)
            axios.post(`/landing/keranjang/${uuid}/atur-kuantitas`, {
                kuantitas: trait
            }).then(response => {
                const res = response.data.data

                const index = this.items.data.findIndex(item => item.uuid === uuid);
                if (index !== -1) {
                    this.items.data[index] = res;
                } else {
                    console.log("Data not found");
                }
            }).catch(error => {
                console.log(error.response.data.message);
                toast.error(error.response.data.message || 'Terjadi Kesalahan!');
            }).finally(() => {
                unblock(this.$el)
            });
        },
        checkout() {
            block(this.$el)
            if (this.selected.length === 0) {
                return toast.error('Pilih barang terlebih dahulu!');
            }

            Swal.fire({
                icon: "info",
                title: "Apakah Anda yakin ingin melakukan pembelian?",
                showCancelButton: true,
                confirmButtonText: "Ya, Beli",
                cancelButtonText: "Batal",
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn fw-semibold btn-light-primary",
                    cancelButton: "btn fw-semibold btn-light-danger",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/landing/keranjang/checkout`, {
                        barang_ids: this.selected
                    }).then(response => {
                        snap.pay(response.data.token, {
                            onSuccess: () => {
                                axios.post(`/landing/keranjang/check-status`, {
                                    barang_ids: this.selected,
                                    order_id: response.data.order_id,
                                    status: 'success'
                                }).then(res => {
                                    this.router.push(`/landing/invoice/${res.data.uuid}`);
                                }).catch(error => {
                                    toast.error(error.response.data.message);
                                    console.log(error.response.data.message);
                                });
                            },
                            onPending: () => {
                                axios.post(`/landing/keranjang/check-status`, {
                                    barang_ids: this.selected,
                                    order_id: response.data.order_id,
                                    status: 'pending'
                                }).catch(error => {
                                    toast.error(error.response.data.message);
                                    console.log(error.response.data.message);
                                });
                            },
                            onError: () => {
                                axios.post(`/landing/keranjang/check-status`, {
                                    barang_ids: this.selected,
                                    order_id: response.data.order_id,
                                    status: 'failed'
                                }).catch(error => {
                                    toast.error(error.response.data.message);
                                    console.log(error.response.data.message);
                                });
                            },
                            onClose: () => {
                                toast.error('Pembayaran Dibatalkan!');
                                axios.post(`/landing/keranjang/check-status`, {
                                    barang_ids: this.selected,
                                    order_id: response.data.order_id,
                                    status: 'failed'
                                }).catch(error => {
                                    toast.error(error.response.data.message);
                                    console.log(error.response.data.message);
                                });
                            },
                        })
                    }).catch(error => {
                        toast.error(error.response.data.message);
                    }).finally(() => {
                        unblock(this.$el)
                    });
                }
            });
        },
        toggleSelectAll() {
            if (this.isAllSelected) {
                this.selected = [];
            } else {
                this.selected = this.items.data.map(item => item.barang.id);
            }
        }
    },
    computed: {
        totalHarga() {
            return this.items.data
                .filter(item => this.selected.includes(item.barang.id))
                .reduce((total, item) => total + (item.barang.harga_diskon || item.barang.harga) * item.kuantitas, 0);
        },
        isAllSelected() {
            return this.items.data?.length > 0 && this.selected.length === this.items.data.length;
        }
    },
    mounted() {
        this.data();
    }
})
</script>