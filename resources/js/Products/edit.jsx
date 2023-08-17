import axios from "axios";
import { useQuery } from "react-query";
import { useParams } from "react-router-dom";

export default function EditProduct() {
    const { id } = useParams();

    const { data: product, isLoading } = useQuery("edit-product", () =>
        axios.get(`/api/products/${id}`).then(({ data }) => data)
    );

    if (isLoading) return <h2>Loading...</h2>;

    return (
        <form className="mt-2">
            <div className="form-group row">
                <label htmlFor="title" className="col-2 col-form-label">
                    Title
                </label>
                <div className="col-10">
                    <input
                        className="form-control"
                        name="title"
                        id="title"
                        type="text"
                        defaultValue={product.title}
                    />
                </div>
            </div>
        </form>
    );
}
