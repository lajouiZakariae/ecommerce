import axios from "axios";
import { useMutation, useQueryClient } from "react-query";

export default function QuickAddProduct() {
    const queryClient = useQueryClient();

    const { mutate } = useMutation(
        async (ev) => {
            ev.preventDefault();
            const { data } = await axios.post(
                "/api/products",
                new FormData(ev.target)
            );
            return data;
        },
        {
            onSuccess: ({ created }) =>
                created ? queryClient.invalidateQueries("products") : null,
        }
    );
    return (
        <form className="row" onSubmit={mutate}>
            <div className="col-10 pe-0">
                <input
                    type="text"
                    name="title"
                    className="form-control"
                    placeholder="Title"
                />
            </div>
            <div className="col-2">
                <button className="btn btn-primary w-100">Add</button>
            </div>
        </form>
    );
}
