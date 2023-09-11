import axios from "axios";
import { useQuery } from "react-query";
import { useParams } from "react-router-dom";

export function ColorBox({ hex, name, className, onClick }) {
    return (
        <div
            className={
                className +
                " border rounded cursor-pointer hover:opacity-70 transition"
            }
            title={name}
            style={{
                backgroundColor: hex,
                width: "30px",
                height: "30px",
            }}
            onClick={onClick}
        ></div>
    );
}

function ColorSelect({ exclude }) {
    const url =
        "/api/colors" +
        exclude
            .reduce((acc, item) => acc + `exclude[]=${item}&`, "?")
            .slice(0, -1);

    const { data, isError, isLoading } = useQuery("colors", () =>
        axios.get(url).then(({ data }) => data)
    );

    console.log(data);

    if (isError) {
        return <span>Error...</span>;
    }

    if (isLoading) {
        return <span>Loading...</span>;
    }

    return (
        <>
            {data.map(({ id, name, hex }) => (
                <ColorBox
                    key={id}
                    name={name}
                    hex={hex}
                    className={"mb-1"}
                    onClick={onClick}
                />
            ))}
        </>
    );
}

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
            <div className="form-group mb-2 row">
                <label htmlFor="title" className="col-2 col-form-label">
                    Colors
                </label>

                <div className="col-10">
                    <div className="d-flex">
                        {product.colors.map(({ id, name, hex }) => (
                            <ColorBox
                                key={id}
                                name={name}
                                hex={hex}
                                className="me-2"
                            />
                        ))}
                        <div className="position-relative" style={{}}>
                            <div
                                className="me-2 mb-1 border rounded text-secondary d-flex justify-content-center align-items-center"
                                style={{
                                    backgroundColor: "",
                                    width: "30px",
                                    height: "30px",
                                    fontSize: "20px",
                                }}
                            >
                                +
                            </div>

                            <div
                                className="position-absolute d-flex flex-wrap border rounded p-1"
                                style={{ top: "100%", width: "100px" }}
                            >
                                <ColorSelect
                                    exclude={product.colors.map(
                                        (color) => color.id
                                    )}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="d-flex justify-content-end">
                <button className="btn btn-secondary">Discard</button>
                <button className="btn btn-success ms-2">Save</button>
            </div>
        </form>
    );
}
