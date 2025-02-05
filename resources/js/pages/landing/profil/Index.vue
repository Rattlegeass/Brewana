<template>
    <div class="container-fluid p-10 border-bottom border-dark-subtle" id="profil">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex gap-8 flex-wrap w-100 justify-content-center">
                            <div class="overflow-hidden rounded shadow-sm" style="height: 150px; width: 175px;">
                                <img :src="`/storage/${store?.user?.photo}`" alt="Gambar User" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                            <div class="d-flex flex-column w-100">
                                <div class="border border-bottom border-gray mb-5"></div>

                                <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column me-5 mb-3 mb-md-0 fs-6">
                                    <li class="nav-item w-100">
                                        <a class="nav-link w-100 active btn btn-flex btn-active-light-success" data-bs-toggle="tab"
                                            href="#tab-akun">
                                            <i class="la la-user-circle text-success fs-1"></i>
                                            <span class="d-flex flex-column align-items-start ms-2">
                                                <span class="fs-4 fw-bold text-success">Akun</span>
                                            </span>
                                        </a>
                                        <!-- <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                            href="#tab-keamanan">
                                            <i class="la la-lock text-primary fs-1"></i>
                                            <span class="d-flex flex-column align-items-start ms-2">
                                                <span class="fs-4 fw-bold text-primary">Keamanan</span>
                                            </span>
                                        </a> -->
                                        <a class="nav-link w-100 btn btn-flex btn-active-light-warning" data-bs-toggle="tab"
                                            href="#tab-riwayat">
                                            <i class="la la-history text-warning fs-1"></i>
                                            <span class="d-flex flex-column align-items-start ms-2">
                                                <span class="fs-4 fw-bold text-warning">Riwayat</span>
                                            </span>
                                        </a>
                                        <a class="nav-link w-100 btn btn-flex btn-active-light-danger" @click="signOut()">
                                            <i class="la la-door-open text-danger fs-1"></i>
                                            <span class="d-flex flex-column align-items-start ms-2">
                                                <span class="fs-4 fw-bold text-danger">Keluar</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-akun" role="tabpanel">
                        <Akun />
                    </div>
                    <!-- <div class="tab-pane fade" id="tab-keamanan" role="tabpanel">
                        <Keamanan />
                    </div> -->
                    <div class="tab-pane fade" id="tab-riwayat" role="tabpanel">
                        <Riwayat />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { block, unblock } from "@/libs/utils";
import Swal from "sweetalert2/dist/sweetalert2.js";
import Akun from "./tabs/Akun.vue";
import Keamanan from "./tabs/Keamanan.vue";
import Riwayat from "./tabs/Riwayat.vue";

export default defineComponent({
    components: {
        Akun,
        Keamanan,
        Riwayat,
    },
    setup() {
        const router = useRouter();
        const store = useAuthStore();
        return {
            router,
            store
        }
    },
    methods: {
        signOut() {
            block(this.$el);
            Swal.fire({
                icon: "warning",
                title: "Apakah Anda yakin ingin keluar?",
                showCancelButton: true,
                confirmButtonText: "Ya, Keluar",
                cancelButtonText: "Batal",
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn fw-semibold btn-light-primary",
                    cancelButton: "btn fw-semibold btn-light-danger",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    this.store.logout();
                    Swal.fire({
                        icon: "success",
                        text: "Berhasil keluar",
                    }).then(() => {
                        this.router.push({ name: "landing" });
                        unblock(this.$el);
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        text: "Gagal keluar",
                    });
                    unblock(this.$el);
                }
            });
        }
    },
    mounted() {
        console.log(this.store)
    }
});
</script>