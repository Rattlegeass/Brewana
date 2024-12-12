<template>
    <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

    <div class="card mb-10">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Daftar Barang</h2>
            <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm" @click="openForm = true">
                Tambah
                <i class="la la-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-kategori" url="/master/barang" :columns="columns"></paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue';
import { useDelete } from "@/libs/hooks";
import { createColumnHelper } from '@tanstack/vue-table';
import { currency } from '@/libs/utils'
import Form from "./Form.vue";

interface Kategori {
    id: number,
    uuid: string,
    nama: string,
    deskripsi: string,
    stok: number,
    kategori_id: number,
    harga: number
}

const column = createColumnHelper<Kategori>();

export default defineComponent({
    components: {
        Form,
    },
    setup() {
        const paginate = ref<any>(null);
        const selected = ref<string>("");
        const openForm = ref<boolean>(false);

        const { delete: deleteKategori } = useDelete({
            onSuccess: () => paginate.value.refetch(),
        });

        const columns = [
            column.accessor("no", {
                header: "No"
            }),
            column.accessor("nama", {
                header: "Nama"
            }),
            column.accessor("deskripsi", {
                header: "Deskripsi"
            }),
            column.accessor("stok", {
                header: "Stok"
            }),
            column.accessor("harga", {
                header: "Harga",
                cell: cell => currency(cell.getValue())
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.getValue();
                            openForm.value = true;
                        }
                    }, h('i', { class: 'la la-pencil fs-2' })),
                    h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () =>  deleteKategori(`/master/barang/${cell.getValue()}`)
                    }, h('i', { class: 'la la-trash fs-2' }))
                ])
            })
        ]

        return {
            paginate,
            selected,
            openForm,
            columns,
            refresh: () => paginate.value.refetch(),
        }
    },
    watch: {
        openForm(val) {
            if (!val) {
                this.selected = "";
            }
            window.scrollTo(0, 0);
        }
    }
})

</script>