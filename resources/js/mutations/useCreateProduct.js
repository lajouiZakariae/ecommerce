import axios from "axios";
import { useMutation } from "react-query";

export default function useCreateProduct() {
    return useMutation(
        ({ ev, product }) => {
            ev.preventDefault();

            const formData = new FormData();
            Object.keys(product).forEach((key) =>
                formData.append(key, product[key])
            );

            return axios.post("/api/products", formData);
        },
        {
            onSuccess: (data) => console.log(data.data),
            onError: (data) => console.log(data.response.data?.errors),
        }
    );
}
