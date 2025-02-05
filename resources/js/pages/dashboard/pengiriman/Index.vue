<template>
    <div class="card mb-10">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Pengiriman Barang Pelanggan</h2>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-pengiriman" url="/pengiriman" :columns="columns"></paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';
import { currency, block, unblock } from '@/libs/utils'
import axios from "@/libs/axios";
import Swal from "sweetalert2/dist/sweetalert2.js";

interface Pengiriman {
    id: number,
    uuid: string,
    pembayaran_id: number,
    pembayaran: {
        id: number,
        uuid: string,
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
        }
        user_id: number,
        user: {
            id: number;
            uuid: string;
            name: string;
            email: string;
            password?: string;
            phone?: number;
            role_id: number;
        }
        kuantitas: number,
        total_harga: number,
        status: string,
    }
    status: string,
}

const column = createColumnHelper<Pengiriman>();

export default defineComponent({
    setup() {
        const paginate = ref<any>(null);
        const selected = ref<string>("");

        const ubahStatus = (uuid, status) => {
            block(document.querySelector("table"))
            Swal.fire({
                icon: "warning",
                title: "Apakah Anda yakin?",
                text: "Status akan diubah! Hal ini tidak dapat dikembalikan.",
                showCancelButton: true,
                confirmButtonText: "Ya, Ubah",
                cancelButtonText: "Batal",
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn fw-semibold btn-light-primary",
                    cancelButton: "btn fw-semibold btn-light-danger",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/pengiriman/${uuid}/update-status`, { status: status }).then(() => {
                        paginate.value.refetch();
                        Swal.fire({
                            icon: "success",
                            text: "Berhasil diubah",
                        });
                    }).catch(() => {
                        Swal.fire({
                            icon: "error",
                            text: "Gagal diubah",
                        });
                    });
                }
            }).finally(() => {
                unblock(document.querySelector("table"));
            });
        }

        const columns = [
            column.accessor("no", {
                header: "No"
            }),
            column.accessor("pembayaran.uuid", {
                header: "Order ID",
                cell: cell => `#${cell.getValue()}`
            }),
            column.accessor("pembayaran.barang.nama", {
                header: "Barang"
            }),
            column.accessor("pembayaran.user.name", {
                header: "User"
            }),
            column.accessor("pembayaran.user.phone", {
                header: "No. Telp"
            }),
            column.accessor("pembayaran.kuantitas", {
                header: "Kuantitas"
            }),
            column.accessor("pembayaran.total_harga", {
                header: "Total Harga",
                cell: cell => currency(cell.getValue())
            }),
            column.accessor("status", {
                header: "Status",
                cell: (cell) => h("div", { class: "d-flex" }, [
                    h(
                        "input",
                        {
                            type: "button",
                            class: cell.row.original.status == 'dikemas' ? "btn btn-sm btn-light-info"  : cell.row.original.status == 'dikirim' ? "btn btn-sm btn-light-primary" : cell.row.original.status == 'diterima' && cell.row.original.pembayaran.status != 'refund' ? "btn btn-sm btn-light-success disabled" : cell.row.original.status == 'diterima' && cell.row.original.pembayaran.status == 'refund' ? "btn btn-sm btn-light-success" : "btn btn-sm btn-light-danger disabled",
                            onClick: () => {
                                if (cell.row.original.status == 'dikemas' || cell.row.original.status == 'dikirim' || (cell.row.original.status == 'diterima' && cell.row.original.pembayaran.status == 'refund')) {
                                    ubahStatus(cell.row.original.uuid, cell.row.original.status);
                                }
                            },
                            value: cell.row.original.status == 'dikemas' ? 'Dikemas' : cell.row.original.status == 'dikirim' ? 'Dikirim' : cell.row.original.status == 'diterima' ? 'Diterima' : 'Refund',
                        },
                    ),
                ])
            }),
        ]

        return {
            paginate,
            selected,
            columns,
            refresh: () => paginate.value.refetch(),
        }
    },
})

</script>