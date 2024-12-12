import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useBarang(options = {}) {
    return useQuery({
        queryKey: ['barangs'],
        queryFn: () => axios.get("/master/barang").then((res: any) => res.data.data),
        ...options
    });
}