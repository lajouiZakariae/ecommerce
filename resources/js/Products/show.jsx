import axios from "axios";
import { useQuery } from "react-query";
import { useParams } from "react-router-dom";

export default function Product() {
    const { id } = useParams();

    const {
        data: product,
        isError,
        isLoading,
    } = useQuery("product", () =>
        axios.get(`/api/products/${id}`).then(({ data }) => data)
    );

    if (isLoading) {
        return <h2>Loading...</h2>;
    }

    if (isError) {
        return <h2>Error</h2>;
    }

    return (
        <div className="card mt-2">
            <div className="card-body">
                <h3 className="card-title">{product.title}</h3>
                <div className="d-flex">
                    {product.colors.map(({ name, hex }) => (
                        <div
                            className="me-2 border rounded"
                            title={name}
                            style={{
                                backgroundColor: hex,
                                width: "30px",
                                height: "30px",
                            }}
                        ></div>
                    ))}
                </div>
            </div>
        </div>
    );
}
