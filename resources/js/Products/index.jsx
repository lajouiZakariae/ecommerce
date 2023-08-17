import axios from "axios";
import { useQuery } from "react-query";
import ProductItem from "./item";
import QuickAddProduct from "./quickAdd";

export default function Products() {
    const { data, isLoading } = useQuery("products", () =>
        axios.get("/api/products").then(({ data }) => data)
    );

    if (isLoading) {
        return <h2>loading...</h2>;
    }

    return (
        <div className="row mt-2">
            <div className="mb-2">
                <h2>Quick Add!</h2>
                <QuickAddProduct />
            </div>
            {data.products.map((product) => (
                <ProductItem key={product.id} {...product} />
            ))}
        </div>
    );
}
