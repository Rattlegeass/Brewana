<template>
  <div class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-primary p-3" id="navbar">
      <div class="container-fluid">
        <router-link class="navbar-brand w-25 text-white fs-4 fw-bold d-flex align-items-center gap-3" to="/landing/home">
          <!-- <img :src="setting?.logo" :alt="setting?.app" width="30"> -->
          <i class="fa fa-coffee fs-3 text-black"></i>
          <span>BREWANA</span>
        </router-link>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="fa fa-bars text-white"></span>
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
            <li class="nav-item" v-if="!JwtService.getToken()">
              <router-link class="nav-link text-white" to="/sign-in">Login</router-link>
            </li>
            <li class="nav-item" v-if="JwtService.getToken()">
              <router-link class="nav-link" to="/landing/keranjang"><i class="la la-shopping-cart fs-1 text-white"></i></router-link>
            </li>
            <li class="nav-item" v-if="JwtService.getToken()">
              <router-link class="nav-link" to="/landing/profil"><i class="la la-user fs-1 text-white"></i></router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="flex-grow-1 container-fluid p-0">
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
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import JwtService from "@/core/services/JwtService";
import { useSetting } from "@/services";

export default defineComponent({
    setup() {
      const auth = useAuthStore();    
      const router = useRouter();
      const store = useAuthStore();
      const { data: setting = {} } = useSetting()

      return {
          auth,
          router,
          store,
          JwtService,
          setting,
      }
    },
    mounted() {
      if (!JwtService.getToken()) {
          JwtService.destroyToken();
          return
      }
      if (this.auth.user?.id == null) {
          JwtService.destroyToken();
          return
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
        border-bottom: 0.22rem solid rgb(0, 0, 0);
        transform: scaleX(0);
        transition: 0.2s linear;
    }
    .nav-link:hover::after{
        transform: scaleX(1);
    }
}
</style>