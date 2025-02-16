<template>
  <div class="row mb-4">
    <div class="col-12 col-md-4 col-lg-4">
      <div class="card p-5 h-100 position-relative">
        <div class="d-inline-flex mb-4">
          <i class="la la-shopping-cart fs-1 text-primary p-3 rounded-circle bg-light-primary"></i>
        </div>
        <div class="mb-2">
          <p class="text-muted mb-1 fs-5">Total Barang Terjual</p>
          <div class="d-flex align-items-baseline">
            <h1 class="fw-bold mb-0 me-2">100</h1>
            <!-- <h1 class="fw-bold mb-0 me-2">{{ transaksi }}</h1> -->
            <p class="text-muted fs-5 mb-0">Unit</p>
          </div>
        </div>
        <div class="mt-4 pt-3 border-top">
          <div class="d-flex justify-content-between text-muted">
            <small>Transaksi Customer</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4 col-lg-4">
      <div class="card p-5 h-100 position-relative">
        <div class="d-inline-flex mb-4">
          <i class="la la-box fs-1 text-warning p-3 rounded-circle bg-light-warning"></i>
        </div>
        <div class="mb-2">
          <p class="text-muted mb-1 fs-5">Total Barang Dikirim</p>
          <div class="d-flex align-items-baseline">
            <h1 class="fw-bold mb-0 me-2">98</h1>
            <!-- <h1 class="fw-bold mb-0 me-2">{{ pengiriman }}</h1> -->
            <p class="text-muted fs-5 mb-0">Unit</p>
          </div>
        </div>
        <div class="mt-4 pt-3 border-top">
          <div class="d-flex justify-content-between text-muted">
            <small>Pengiriman Barang</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4 col-lg-4">
      <div class="card p-5 h-100 position-relative">
        <div class="d-inline-flex mb-4">
          <i class="la la-dollar-sign fs-1 text-success p-3 rounded-circle bg-light-success"></i>
        </div>
        <div class="mb-2">
          <p class="text-muted mb-1 fs-5">Total Pendapatan</p>
          <div class="d-flex align-items-baseline">
            <h1 class="fw-bold mb-0 me-2">Rp. 7.255.000</h1>
            <!-- <h1 class="fw-bold mb-0 me-2">{{ currency(pemasukan) }}</h1> -->
            <p class="text-muted fs-5 mb-0"></p>
          </div>
        </div>
        <div class="mt-4 pt-3 border-top">
          <div class="d-flex justify-content-between text-muted">
            <small>Pemasukkan</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12 col-md-4 col-lg-4">
      <div class="card bg-primary p-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="mb-1 text-white">Friends</p>
            <h3 class="text-white fw-bold">768</h3>
          </div>
          <div class="border border-white rounded-circle bg-light-primary d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
            <i class="la la-facebook fs-1 text-primary"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4 col-lg-4">
      <div class="card bg-info p-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="mb-1 text-white">Followers</p>
            <h3 class="text-white fw-bold">3.682</h3>
          </div>
          <div class="border border-white rounded-circle bg-light-info d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
            <i class="la la-instagram fs-1 text-info"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4 col-lg-4">
      <div class="card bg-primary p-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="mb-1 text-white">Followers</p>
            <h3 class="text-white fw-bold">1.902</h3>
          </div>
          <div class="border border-white rounded-circle bg-light-primary d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
            <i class="la la-twitter fs-1 text-primary"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- <main> -->
    <!-- <div class="card">
      <div class="card-body row">
        <div class="col-4"></div>
        <div class="col-4"></div>
        <div class="col-4"></div>
      </div>
    </div> -->

    <!-- <div class="card-body mt-20">
      <div class="mt-n20 position-relative">
        <div class="row g-3 g-lg-6">
          
          <div class="col-xl-4 col-sm-6">
            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-success border-left-5 border-start d-block">
              <div class="symbol symbol-30px me-5 mb-8">
                <span class="symbol-label">
                  <i class="ki-duotone ki-code fs-2x text-success">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                  </i>
                </span>
              </div>
              <div class="m-0 d-flex justify-content-between align-items-center">
                <div>
                  <span class="text-success fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 cursor">
                  Pembayaran
                  </span>
                  <span class="text-gray-500 fw-semibold fs-6 cursor">Pemasukan</span>
                </div>
                <div class="btn-group">
                  <button class="btn btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-chevron-down text-success fs-2"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><router-link class="dropdown-item" to="/admin/dashboard/booking">Booking</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/promotion">Promotion</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/setting">Setting</router-link></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-sm-6">
            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-warning border-left-5 border-start d-block">
              <div class="symbol symbol-30px me-5 mb-8">
                <span class="symbol-label">
                  <i class="ki-duotone ki-gear fs-2x text-warning">
                    <span class="path1"></span>
                    <span class="path2"></span>
                  </i>
                </span>
              </div>
              <div class="m-0 d-flex justify-content-between align-items-center">
                <div>
                  <span class="text-warning fw-bolder cursor d-block fs-2qx lh-1 ls-n1 mb-1">
                  Master
                  </span>
                  <span class="text-gray-500 fw-semibold cursor fs-6">article, banner, brand, ...</span>
                </div>
                <div class="btn-group">
                  <button class="btn btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-chevron-down text-warning fs-2"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/article">Article</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/banner">Banner</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/brand">Brand</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/kota">City</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/destinasi">Destination</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/hotel">Hotel</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/hotel_facility">Hotel Facility</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/provinsi">Province</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/promo">Promo</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/room_facility">Room Facility</router-link></li>
                    <li><router-link class="dropdown-item" to="/admin/dashboard/master/users">User</router-link></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div v-if="local" class="col-xl-4 col-sm-6">
            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-info border-left-5 border-start d-block">
              <div class="symbol symbol-30px me-5 mb-8">
                <span class="symbol-label">
                  <i class="ki-duotone ki-send fs-2x text-info">
                    <span class="path1"></span>
                    <span class="path2"></span>
                  </i>
                </span>
              </div>
              <div class="m-0 d-flex justify-content-between align-items-center">
                <div>
                  <span class="text-info fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 cursor">
                  Go To Booking
                  </span>
                  <span class="text-gray-500 fw-semibold fs-6 cursor">go to booking page</span>
                </div>
                <i class="fa fa-chevron-right text-info fs-2 pointer" @click="butt"></i>
              </div>
            </div>
          </div>
          <div v-else class="col-xl-4 col-sm-6">
            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-info border-left-5 border-start d-block">
              <div class="symbol symbol-30px me-5 mb-8">
                <span class="symbol-label">
                  <i class="ki-duotone ki-send fs-2x text-info">
                    <span class="path1"></span>
                    <span class="path2"></span>
                  </i>
                </span>
              </div>
              <div class="m-0 d-flex justify-content-between align-items-center">
                <div>
                  <span class="text-info fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 cursor">
                  Booking Now!
                  </span>
                  <span class="text-gray-500 fw-semibold fs-6 cursor">go to landing page</span>
                </div>
                <router-link to="/landing/page">
                  <i class="fa fa-chevron-right text-info fs-2"></i>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
  <!-- </main> -->
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from "@/libs/axios";
import { toast } from "vue3-toastify";
import { currency, formatNumber, block, unblock } from "@/libs/utils";

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

export default defineComponent({
    setup() {
        const router = useRouter();
        const items = ref<Barang>({} as Barang);

        const pemasukan = ref('')
        const pengiriman = ref('')
        const transaksi = ref('')

        return {
            router,
            items,
            currency,
            pemasukan,
            pengiriman,
            transaksi,
        }
    },
    methods: {
        income() {
            axios.get('/dashboard/income').then(response => {
                this.pemasukan = response.data.total_penjualan
            }).catch(error => {
                toast.error(error.response.data.message)
            })
        },
        sent() {
            axios.get('/dashboard/sent').then(response => {
                this.pengiriman = response.data.total_pengiriman
            }).catch(error => {
                toast.error(error.response.data.message)
            })
        },
        transaction() {
            axios.get('/dashboard/transaction').then(response => {
                this.transaksi = response.data.total_transaksi
            }).catch(error => {
                toast.error(error.response.data.message)
            })
        },
    },
    mounted() {
        this.income();
        this.sent();
        this.transaction();
    }
})
</script>