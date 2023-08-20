import axios from "axios";
import { useMutation, useQueryClient } from "react-query";
import { useParams } from "react-router-dom";
import Input from "../Components/Input";

export default function QuickAddProduct() {
    const { id } = useParams();
    const queryClient = useQueryClient();

    const { mutate, isError, error } = useMutation(
        async (ev) => {
            ev.preventDefault();
            const formData = new FormData(ev.target);
            console.log(id);
            if (id) formData.append("category_id", id);

            const { data } = await axios.post("/api/products", formData);
            return data;
        },
        {
            onSuccess: ({ created }) =>
                created ? queryClient.invalidateQueries("products") : null,
        }
    );

    return (
        <form className="row" onSubmit={mutate}>
            <div className="flex mt-2">
                <Input type="text" name="title" placeholder="Title" />
                <button className="ms-2 p-2 bg-slate-950 text-white rounded-lg px-6 hover:bg-slate-800 transition">
                    Add
                </button>
            </div>
            <div className="text-red-600">
                {isError ? error.response.data.message : null}
            </div>
        </form>
    );
}
