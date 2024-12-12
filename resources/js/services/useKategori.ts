import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useKategori(options = {}) {
    return useQuery({
        queryKey: ['kategoris'],
        queryFn: () => axios.get("/master/kategori").then((res: any) => res.data.data),
        ...options
    });
}