<template>
    <!-- bagian 1 -->
    <div class="container p-5 border-bottom border-dark-subtle" id="home">
        <div class="row align-items-center my-10">
            <div class="col-6 text-start mb-2">
                <h1 class="display-4 fw-bold text-primary mb-3">SELAMAT DATANG DI BREWANA</h1>
                <h4 class="mb-5">Kami menjual peralatan dan biji kopi berkualitas</h4>
                <button class="btn btn-dark btn-lg text-white" @click="router.push('/landing/toko')">Jelajah Sekarang</button>
            </div>

            <div class="col-6 text-center">
                <img src="../assets/home-image/image1.jpg" alt="gambar1" class="img-fluid rounded shadow" style="max-width: 90%;">
            </div>
        </div>
    </div>

    <!-- bagian 2 -->
    <div class="container p-5 border-bottom border-dark-subtle">
        <div class="row align-items-center my-10">
            <div class="col-12 mx-auto overflow-hidden rounded-4 p-0" style="width: 90%; height: 450px">
                <img src="../assets/home-image/image2.jpg" alt="gambar2" class="img-fluid w-100 h-auto">
            </div>
            <div class="col-12 text-center mt-10 px-10">
                <h1 class="display-4 fw-bold text-primary mb-3">KENAPA HARUS PILIH BREWANA?</h1>
                <h4 class="mb-5">Kami lebih mengutamakan kepuasan pelanggan kami, dengan menawarkan produk lokal dan impor yang berkualitas. Mari temukan cita rasa yang sempurna bersama kami.</h4>
                <button class="btn btn-dark btn-lg text-white" @click="router.push('/landing/tentang-kami')">Pelajari Lebih Lanjut</button>
            </div>
        </div>
    </div>

    <div class="container p-5">
        <div class="row align-items-center my-10">
            <div class="col-12 text-center px-10">
                <h1 class="display-4 fw-bold text-primary mb-10">APA KATA PARA PELANGGAN TENTANG BREWANA?</h1>
            </div>
            
            <div class="col-12">
                <div class="row g-4">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="rounded-circle overflow-hidden mb-10" style="width: 125px; height: 125px;">
                                    <img src="../assets/home-image/image3.jpg" alt="gambar3" class="img-fluid w-100 h-100 object-fit-cover">
                                </div>
                                <h4 class="text-center mt-4">
                                    "Alat pembuat kopi dari Brewana sangat praktis dan mudah digunakan. Desainnya juga stylish, cocok untuk dapur minimalis saya!"                                </h4>
                                <h3 class="text-center mt-4">Raka Pratama</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="rounded-circle overflow-hidden mb-10" style="width: 125px; height: 125px;">
                                    <img src="../assets/home-image/image4.jpg" alt="gambar3" class="img-fluid w-100 h-100 object-fit-cover">
                                </div>
                                <h4 class="text-center mt-4">
                                    "Saya sudah coba banyak merek kopi, tapi Brewana punya karakter rasa yang unik dan aftertaste yang smooth. Sempurna untuk pecinta kopi sejati!"                                </h4>
                                <h3 class="text-center mt-4">Nadia Siregar</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="rounded-circle overflow-hidden mb-10" style="width: 125px; height: 125px;">
                                    <img src="../assets/home-image/image5.jpg" alt="gambar3" class="img-fluid w-100 h-100 object-fit-cover">
                                </div>
                                <h4 class="text-center mt-4">
                                    "Saya baru belajar membuat kopi manual, dan alat dari Brewana sangat membantu! Instruksi penggunaannya jelas, dan hasil kopinya terasa seperti dari coffee shop."                                </h4>
                                <h3 class="text-center mt-4">Aditya Wijaya</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 text-center mt-10 px-10">
                <h4 class="mb-5">Umpan balik anda membantu kami menjadi lebih baik.</h4>
                <button type="button" class="btn btn-dark btn-lg text-white" data-bs-toggle="modal" data-bs-target="#umpanModal">Beri Umpan!</button>
            </div>
        </div>
    </div>
    
    <div class="modal fade" tabindex="-1" id="umpanModal" aria-labelledby="umpanModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Umpan Balik</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-bold text-dark fs-6">Berikan Umpan Balik Anda!</label>
                    <Field name="umpan" autocomplete="off" >
                        <textarea class="form-control form-control-lg form-control-solid" name="umpan" rows="2" v-model="pesan"></textarea>
                    </Field>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="umpanBalik()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useAuthStore } from '@/stores/auth';
import JwtService from "@/core/services/JwtService";
import axios from "@/libs/axios";
import { toast } from "vue3-toastify";

export default defineComponent({
    setup() {
        const router = useRouter();
        const route = useRoute();
        const auth = useAuthStore();
        const pesan = ref<string>('');

        return {
            router,
            route,
            auth,
            JwtService,
            pesan
        }
    },
    methods: {
        umpanBalik() {
            if (!JwtService.getToken()) {
                JwtService.destroyToken();
                return this.router.push({ name: 'sign-in', query: { redirect: this.route.fullPath } })
            }
            if (this.auth.user?.id == null) {
                JwtService.destroyToken();
                toast.error('Anda harus login terlebih dahulu!');
                return this.router.push({ name: 'sign-in', query: { redirect: this.route.fullPath } })
            }
            axios.post('/landing/home/umpan-balik', {
                user_id: this.auth.user.id,
                pesan: this.pesan
            }).then(() => {
                this.pesan = '';
                toast.success('Umpan balik berhasil dikirimkan');
            }).catch((error) => {
                toast.error(error.response.data.message);
            }).finally(() => {
                location.reload();
            });
        }
    }
})
</script>