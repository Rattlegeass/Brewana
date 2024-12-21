<template>
    <div class="container-fluid p-0 border-bottom border-dark-subtle bg-success" id="tentang-kami">
        <div class="d-flex flex-row justify-content-center align-items-center" style="width: 100%; height: 400px">
            <button class="btn btn-dark btn-lg text-white" @click="signOut()">LOGOUT</button>
        </div>
    </div>
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