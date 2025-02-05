<template>
    <div class="card mb-10">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Riwayat Pembayaran Pelanggan</h2>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-pembayaran" url="/pembayaran" :columns="columns"></paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';
import { currency, block, unblock } from '@/libs/utils'
import axios from "@/libs/axios";
import Swal from "sweetalert2/dist/sweetalert2.js";

interface Pembayaran {
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
    order_id: string;
    pengiriman_id: BigInteger;
    pengiriman: {
        id: BigInteger;
        uuid: string;
        order_id: string;
        ongkir: number;
        status: string;
    };
}

const column = createColumnHelper<Pembayaran>();

export default defineComponent({
    setup() {
        const paginate = ref<any>(null);
        const selected = ref<string>("");

        const ubahStatus = (uuid) => {
            block(document.querySelector("table"))
            Swal.fire({
                icon: "warning",
                title: "Apakah Anda yakin?",
                text: "Status akan diubah menjadi Refund! Hal ini tidak dapat dikembalikan.",
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
                    axios.post(`/pembayaran/${uuid}/update-status`, { status: 'refund' }).then(() => {
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
            column.accessor("uuid", {
                header: "Order ID",
                cell: cell => `#${cell.getValue()}`
            }),
            column.accessor("barang.nama", {
                header: "Barang"
            }),
            column.accessor("user.name", {
                header: "User"
            }),
            column.accessor("user.phone", {
                header: "No. Telp"
            }),
            column.accessor("kuantitas", {
                header: "Kuantitas"
            }),
            column.accessor("total_harga", {
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
                            class: cell.row.original.status == 'pending' ? "btn btn-sm btn-light-warning disabled"  : cell.row.original.status == 'success' ? "btn btn-sm btn-light-success" : "btn btn-sm btn-light-danger disabled",
                            onClick: () => {
                                if (cell.row.original.status == 'success') {
                                    ubahStatus(cell.row.original.uuid);
                                }
                            },
                            value: cell.row.original.status == 'pending' ? 'Pending' : cell.row.original.status == 'success' ? 'Berhasil' : cell.row.original.status == 'failed' ? 'Gagal' : 'Refund',
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