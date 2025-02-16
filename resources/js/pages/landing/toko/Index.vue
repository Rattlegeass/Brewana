<template>
    <div class="container-fluid mt-10">
        <div class="d-flex justify-content-center align-items-center">
            <div class="card w-75 h-75 rounded p-3">
                <div class="bg-white">
                    <splide :options="{autoplay: true, interval: 3000, pauseOnHover: true, arrows: false, pagination: true, type: 'loop', perMove: 1, focus: 'center'}" class="h-100 w-100">
                        <splide-slide v-for="(item, index) in promoItems" :key="index" class="d-flex justify-content-center align-items-center">
                            <img :src="`/storage/${item.image}`" class="img-fluid" @click="console.log(index)">
                        </splide-slide>
                    </splide>
                </div>
            </div>
        </div>
    </div>

    <div class="container p-10 g-5" id="toko">
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
                <div class="card-header"></div>
                <div class="card-body" @click="router.push(`/landing/toko/${item.uuid}/${item.id}/detail`)" style="cursor: pointer;">
                    <div class="row g-3">
                        <div class="col-12 col-md-3 col-sm-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="overflow-hidden rounded shadow-sm" style="height: 150px; width: 175px;">
                                <img :src="`/storage/${item.barang_images[0]?.image}`" alt="Gambar Vertikal" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                        </div>

                        <div class="col-12 col-md-9 col-sm-6 d-flex flex-column justify-content-center">
                            <h2 class="fw-bold">{{ item.nama }}</h2>
                            <p class="card-text text-muted mb-4">Kategori: <span class="text-dark">{{ item.kategori.nama }}</span></p>
                            <p class="text-muted mb-4">{{ item.deskripsi }}</p>
                            <h4 class="text-primary fw-bold">
                                <span v-if="item.harga_diskon" class="text-decoration-line-through opacity-25 me-2">{{ currency(item.harga) }}</span>
                                <span v-if="item.harga_diskon">{{ currency(item.harga_diskon) }}</span>
                                <span v-if="item.harga_diskon == null">{{ currency(item.harga) }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-footer"></div>
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
            <div v-if="!items.uuid" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from "@/libs/axios";
import { toast } from "vue3-toastify";
import { currency, block, unblock } from "@/libs/utils";

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

interface Promo {
    id: number,
    uuid: string,
    nama: string,
    deskripsi: string,
    image: string,
    periode_awal: string,
    periode_akhir: string,
    potongan_harga: number
}

export default defineComponent({
    setup() {
        const router = useRouter();
        const items = ref<Barang>({} as Barang);
        const promoItems = ref<Promo>({} as Promo);
        const search = ref('');

        return {
            router,
            items,
            promoItems,
            search,
            currency,
        }
    },
    methods: {
        data(url = '/landing/toko/get') {
            // block(this.$el)
            axios.post(url, {
                search: this.search
            }).then(response => {
                this.items = response.data.items
            }).catch(error => {
                toast.error(error.response.data.message)
            }).finally(() => {
                // unblock(this.$el)
            });
        },
        dataPromo() {
            // block(this.$el)
            axios.get('/landing/toko/promo/get').then(response => {
                this.promoItems = response.data
            }).catch(error => {
                toast.error(error.response.data.message)
            }).finally(() => {
                // unblock(this.$el)
            });
        }
    },
    mounted() {
        this.dataPromo();
        this.data();
    }
})
</script>