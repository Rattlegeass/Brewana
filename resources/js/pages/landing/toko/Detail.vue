<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div v-if="item.uuid">
                    <div class="card shadow-lg position-relative">
                        <button class="btn btn-light border rounded-circle position-absolute p-2 ps-3 ms-2 mt-2"
                            type="button" @click="router.push('/landing/toko')">
                            <i class="la la-arrow-left"></i>
                        </button>

                        <div class="row g-0">
                            <div class="col-md-5">
                                <img :src="`/storage/${item?.barang_images[0]?.image}`"
                                    class="img-fluid rounded-start" alt="Item Image"
                                    style="object-fit: cover; height: 100%;">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h3 class="card-title fw-bold">{{ item.nama }}</h3>
                                    <p class="card-text text-muted">Kategori: 
                                        <span class="text-dark">{{ item.kategori?.nama }}</span>
                                    </p>
                                    <p class="card-text">{{ item.deskripsi }}</p>
                                    <h4 class="text-primary fw-bold mb-4">
                                        <span v-if="item.harga_diskon" 
                                            class="text-decoration-line-through opacity-25 me-2">
                                            {{ currency(item.harga) }}
                                        </span>
                                        <span v-if="item.harga_diskon">{{ currency(item.harga_diskon) }}</span>
                                        <span v-else>{{ currency(item.harga) }}</span>
                                    </h4>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="badge bg-success me-2 text-white" v-if="item.stok > 0">Stok Tersedia</span>
                                        <span class="badge bg-danger me-2 text-white" v-if="item.stok == 0">Stok Habis</span>
                                        <small class="text-muted">Tersisa {{ item.stok }} unit</small>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary btn-lg" @click="belanja('beli')">Beli Sekarang</button>
                                        <button class="btn btn-outline-secondary btn-lg" @click="belanja('keranjang')">Tambahkan ke Keranjang</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalKomentar" tabindex="-1" aria-labelledby="modalKomentarLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalKomentarLabel">Tambah Komentar</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <textarea class="form-control form-control-lg form-control-solid" rows="3" v-model="komentarBaru"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary" @click="kirimKomentar">Kirim</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="komentars.data?.length > 0" class="card mt-4 shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Komentar</span>
                                <button v-if="!komentars.data.some(k => k.user_id === auth.user.id && k.barang_id === item.id)" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalKomentar">
                                    Tambah Komentar
                                </button>
                            </div>
    
                            <div class="mt-4">
                                <div class="border-bottom pb-2 mb-2" v-for="(komentar, index) in komentars.data" :key="index">
                                    <p class="mb-1">{{ komentar.komentar }}</p>
                                    <small class="text-muted">Oleh: {{ komentar.user?.name }}</small>
                                </div>
                            </div>
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination">
                                    <li v-for="(link, index) in komentars.links" :key="index" :class="['page-item', { disabled: !link.url, active: link.active }]">
                                        <a class="page-link" v-if="link.url" href="#" @click.prevent="dataKomentars(link.url)">
                                            <span v-html="link.label"></span>
                                        </a>
                                        <span v-else class="page-link" v-html="link.label"></span>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div v-else class="card mt-4 shadow-sm">
                        <div class="card-body">
                            <div class="text-center">
                                <h3>Komentar Kosong</h3>
                                <button v-if="auth.user.id" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalKomentar">
                                    Tambah Komentar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center pt-15">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script lang="ts">
import { defineComponent, ref } from "vue";
import { block, unblock } from "@/libs/utils";
import axios from "@/libs/axios";
import { useRoute, useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import { currency } from "@/libs/utils";
import JwtService from "@/core/services/JwtService";
import { useAuthStore } from '@/stores/auth';
import Swal from "sweetalert2/dist/sweetalert2.js";

interface Barang {
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
}

interface Komentar {
    user_id: number,
    user: {
        id: number;
        uuid: string;
        name: string;
        email: string;
        password?: string;
        phone?: number;
        role_id: number;
    },
    barang_id: string,
    barang: {
        id: number,
        uuid: string,
        nama: string,
        deskripsi: string,
        stok: number,
        kategori_id: number,
        harga: number
        barang_images: {
            id: number,
            uuid: string,
            image: string
            barang_id: number,
        }
    },
    komentar: string,
}

export default defineComponent({
    setup() {
        const auth = useAuthStore();    
        const route = useRoute();
        const router = useRouter();
        const item = ref<Barang>({} as Barang);
        const komentars = ref<Komentar[]>([]);
        const komentarBaru = ref("");

        return {
            route,
            router,
            item,
            currency,
            JwtService,
            auth,
            komentars,
            komentarBaru,
        }
    },
    methods: {
        itemData() {
            block(this.$el)
            axios.get(`/landing/toko/detail/${this.route.params.uuid}/get`).then(response => {
                this.item = response.data.item
            }).catch(error => {
                toast.error(error.response.data.message)
            }).finally(() => {
                unblock(this.$el)
            });
        },
        belanja(trait) {
            if (!JwtService.getToken()) {
                JwtService.destroyToken();
                return this.router.push({ name: 'sign-in', query: { redirect: this.route.fullPath } })
            }
            if (this.auth.user?.id == null) {
                JwtService.destroyToken();
                toast.error('Anda harus login terlebih dahulu!');
                return this.router.push({ name: 'sign-in', query: { redirect: this.route.fullPath } })
            }
            if (trait === 'beli') {
                let quantity = 1;

                Swal.fire({
                    title: "Masukkan kuantitas yang ingin dibeli",
                    icon: "info",
                    html: `
                        <div class="d-flex justify-content-center align-items-center gap-2 m-0">
                            <button id="btn-decrease" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="la la-minus ms-1"></i>
                            </button>
                            <div id="quantity-display" class="border border-dark-subtle px-3 py-1 mt-5 rounded bg-light text-center">
                                <span class="fw-bold">${quantity}</span>
                            </div>
                            <button id="btn-increase" class="btn btn-sm btn-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="la la-plus ms-1"></i>
                            </button>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: "Beli Sekarang",
                    cancelButtonText: "Batal",
                    reverseButtons: true,
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: "btn fw-semibold btn-info",
                        cancelButton: "btn fw-semibold btn-secondary",
                    },
                    didOpen: () => {
                        const btnDecrease = document.getElementById("btn-decrease");
                        const btnIncrease = document.getElementById("btn-increase");
                        const quantityDisplay = document.getElementById("quantity-display");

                        btnDecrease.addEventListener("click", () => {
                            if (quantity > 1) {
                                quantity--;
                                quantityDisplay.innerHTML = `<span class="fw-bold">${quantity}</span>`;
                            }
                        });

                        btnIncrease.addEventListener("click", () => {
                            if (quantity < this.item.stok ) {
                                quantity++;
                                quantityDisplay.innerHTML = `<span class="fw-bold">${quantity}</span>`;
                            }
                        });
                    },
                    preConfirm: () => {
                        return quantity;
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        block(this.$el)
                        axios.post('/landing/toko/detail/beli', {
                            barang_id: this.item.id,
                            user_id: this.auth.user.id,
                            kuantitas: quantity,
                        }).then(response => {
                            snap.pay(response.data.token, {
                                onSuccess: () => {
                                    axios.post('/landing/toko/detail/check-status', {
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
                                    axios.post('/landing/toko/detail/check-status', {
                                        order_id: response.data.order_id,
                                        status: 'pending'
                                    }).catch(error => {
                                        toast.error(error.response.data.message);
                                        console.log(error.response.data.message);
                                    });
                                },
                                onError: () => {
                                    axios.post('/landing/toko/detail/check-status', {
                                        order_id: response.data.order_id,
                                        status: 'failed'
                                    }).catch(error => {
                                        toast.error(error.response.data.message);
                                        console.log(error.response.data.message);
                                    });
                                },
                                onClose: () => {
                                    toast.error('Pembayaran Dibatalkan!');
                                    axios.post('/landing/toko/detail/check-status', {
                                        order_id: response.data.order_id,
                                        status: 'failed'
                                    }).catch(error => {
                                        toast.error(error.response.data.message);
                                        console.log(error.response.data.message);
                                    });
                                },
                            })
                        }).catch(error => {
                            toast.error(error.response.message)
                        }).finally(() => {
                            unblock(this.$el)
                        });
                    }
                });

                return;
            }

            if (trait === 'keranjang') {
                block(this.$el)
                let harga = this.item.harga
                if (this.item.harga_diskon) {
                    harga = this.item.harga_diskon
                }
                axios.post('/landing/toko/detail/keranjang', {
                    barang_id: this.item.id,
                    user_id: this.auth.user.id,
                    harga: harga
                }).then(response => {
                    Swal.fire({
                        icon: response.data.message === "Barang berhasil ditambahkan ke keranjang" ? "success" : "info",
                        text: response.data.message,
                        showCancelButton: true,
                        confirmButtonText: "Periksa Keranjang",
                        cancelButtonText: "Lanjutkan Belanja",
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: "btn fw-semibold btn-light-primary",
                            cancelButton: "btn fw-semibold btn-light-info",
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.router.push({ name: "landing.keranjang" });
                        }
                    })
                }).catch(error => {
                    toast.error(error.response.data.message)
                }).finally(() => {
                    unblock(this.$el)
                });
                
                return
            }
        },
        dataKomentars(url = `/landing/toko/detail/komentar/${this.route.params.id}/get`) {
            axios.post(url).then(response => {
                this.komentars = response.data.items
            }).catch(error => {
                toast.error(error.response.data.message)
            });
        },
        kirimKomentar() {
            axios.post('/landing/toko/detail/komentar/tambah-komentar', {
                user_id: this.auth.user.id,
                barang_id: this.item.id,
                komentar: this.komentarBaru
            }).then(() => {
                this.komentarBaru = "";
                toast.success("Komentar berhasil dikirim!");
            }).catch(error => {
                toast.error(error.response.data.message)
            }).finally(() => {
                location.reload();
            });
        }
    },
    mounted() {
        this.itemData();
        this.dataKomentars();
    }
})
</script>