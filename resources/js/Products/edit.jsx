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
            <div className="form-group mb-2 row">
                <label htmlFor="title" className="col-2 col-form-label">
                    Title
                </label>

                <div className="col-10">
                    <input
                        className="form-control"
                        name="title"
                        id="title"
                        type="text"
                        placeholder="Title"
                        defaultValue={product.title}
                    />
                </div>
            </div>
            <div className="form-group mb-2 row">
                <label htmlFor="title" className="col-2 col-form-label">
                    Descripition
                </label>

                <div className="col-10">
                    <textarea
                        className="form-control"
                        name="title"
                        id="title"
                        type="text"
                        placeholder="Description"
                        defaultValue={product.description}
                    ></textarea>
                </div>
            </div>
            <div className="form-group mb-2 row">
                <label htmlFor="title" className="col-2 col-form-label">
                    Price
                </label>

                <div className="col-10">
                    <input
                        className="form-control"
                        name="title"
                        id="title"
                        type="text"
                        defaultValue={product.price}
                    />
                </div>
            </div>
            <div className="form-group mb-2 row">
                <label htmlFor="title" className="col-2 col-form-label">
                    Quantity
                </label>

                <div className="col-10">
                    <input
                        className="form-control"
                        name="title"
                        id="title"
                        type="text"
                        defaultValue={product.quantity}
                    />
                </div>
            </div>
            <div className="d-flex justify-content-end">
                <button className="btn btn-secondary">Discard</button>
                <button className="btn btn-success ms-2">Save</button>
            </div>
        </form>
    );
}
