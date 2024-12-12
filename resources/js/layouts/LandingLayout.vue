<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar">
    <div class="container">
      <a class="navbar-brand custom-brand" href="#">ElegantNav</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link custom-link" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-link" href="#features">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-link" href="#pricing">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-link" href="#contact">Contact</a>
          </li>
        </ul>
        <button class="btn btn-primary rounded-pill ms-3 custom-button">Get Started</button>
      </div>
    </div>
  </nav>

    <div>
        <button class="btn btn-primary" @click="signOut()">Logout</button>
    </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { useRouter } from "vue-router";
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
<style scoped>
/* General Styling */
.custom-navbar {
  background: linear-gradient(135deg, #4e54c8, #8f94fb); /* Gradient background */
  padding: 1rem 1.5rem;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.custom-brand {
  font-family: 'Poppins', sans-serif;
  font-size: 1.8rem;
  font-weight: 700;
  color: #ffffff;
  text-transform: uppercase;
}

.navbar-toggler {
  border: none;
}

.navbar-toggler-icon {
  filter: invert(1); /* Makes icon white for dark backgrounds */
}

.custom-link {
  font-family: 'Poppins', sans-serif;
  font-size: 1rem;
  font-weight: 500;
  color: #e0e0e0;
  margin: 0 0.75rem;
  transition: color 0.3s ease, transform 0.3s ease;
}

.custom-link:hover {
  color: #ffffff;
  transform: scale(1.1);
  text-shadow: 0 2px 4px rgba(255, 255, 255, 0.4);
}

.custom-button {
  font-family: 'Poppins', sans-serif;
  font-size: 0.9rem;
  font-weight: 600;
  padding: 0.5rem 1.5rem;
  background-color: #ffffff;
  color: #4e54c8;
  border: none;
  transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
}

.custom-button:hover {
  background-color: #8f94fb;
  color: #ffffff;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>