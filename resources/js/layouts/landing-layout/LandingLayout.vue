<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-primary p-3" id="navbar">
    <div class="container-fluid">
      <router-link class="navbar-brand w-25 text-white fs-4 fw-bold" to="/landing/home">BREWANA</router-link>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse text-center" id="navbarNav">
        <ul class="navbar-nav mx-auto justify-content-center">
          <li class="nav-item">
            <router-link class="nav-link text-white" to="/landing/home">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-white" to="/landing/toko">Toko</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-white" to="/landing/tentang-kami">Tentang Kami</router-link>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/landing/keranjang"><i class="la la-shopping-cart fs-1 text-white"></i></router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/landing/profil"><i class="la la-user fs-1 text-white"></i></router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid p-0 m-0">
    <RouterView />
  </div>
  <footer class="container-fluid bg-primary text-white py-4">
    <div class="row align-items-center p-3">
      <div class="col-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
        <router-link class="text-white fs-4 fw-bold" to="/landing/home">BREWANA</router-link>
      </div>
      
      <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
        <div class="d-flex justify-content-center gap-4">
          <a href="#" class="text-white">
            <i class="la la-instagram text-white fs-3"></i>
          </a>
          
          <a href="#" class="text-white">
            <i class="la la-facebook text-white fs-3"></i>
          </a>
          
          <a href="#" class="text-white">
            <i class="la la-twitter text-white fs-3"></i>
          </a>
        </div>
      </div>
      
      <div class="col-12 col-md-4 text-center text-md-end">
        <span>&copy; 2024 All Rights Reserved</span>
      </div>
    </div>
  </footer>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { useRouter, RouterView } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import Swal from "sweetalert2/dist/sweetalert2.js";

export default defineComponent({
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
            Swal.fire({
                icon: "warning",
                text: "Apakah Anda yakin ingin keluar?",
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
                        this.router.push({ name: "sign-in" });
                    });
                }
            });
        }
    }
});
</script>
<style>
.navbar{
    transition: background-color 0.3s, color 0.3s;
}
.navbar-toggler{
    border: none;
    font-size: 1.5rem;
}
.navbar-toggler:focus{
    box-shadow: none;
    outline: none;
}
.navbar.bg-transparent .nav-link{
    color: white;
}
.nav-link{
    font-weight: 500;
}
.nav-link:hover{
    color: black;
}

@media (min-width: 991px){
    .nav-link::after{
        content: "";
        display: block;
        border-bottom: 0.22rem solid rgb(255, 255, 255);
        transform: scaleX(0);
        transition: 0.2s linear;
    }
    .nav-link:hover::after{
        transform: scaleX(1);
    }
}
</style>