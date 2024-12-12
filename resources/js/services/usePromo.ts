import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function usePromo(options = {}) {
    return useQuery({
        queryKey: ['promos'],
        queryFn: () => axios.get("/master/promo").then((res: any) => res.data.data),
        ...options
    });
}