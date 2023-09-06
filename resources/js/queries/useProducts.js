import axios from "axios";
import { useQuery } from "react-query";

export default function useProducts() {
    return useQuery({
        queryKey: ["products"],
        queryFn: () =>
            axios.get(`/api/products?sortBy=latest`).then(({ data }) => data),
    });
}
