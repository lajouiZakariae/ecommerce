import axios from "axios";
import { useQuery } from "react-query";
import ProductItem from "./item";
import QuickAddProduct from "./quickAdd";
import { useParams } from "react-router-dom";

export default function Products() {
    const { id } = useParams();
    const { data: products, isLoading } = useQuery("products", () =>
        axios
            .get(`/api/products${id ? "?category=" + id : ""}`)
            .then(({ data }) => data)
    );

    if (isLoading) {
        return <h2>loading...</h2>;
    }
    return (
        <div>
            <div className="mb-2">
                <h2 className="text-2xl font-bold text-gray-900 tracking-tighter">
                    Quick Add!
                </h2>
                <QuickAddProduct />
            </div>
            <div className="mx-auto">
                <h2 className="text-2xl font-bold tracking-tight text-gray-900">
                    Products Listing
                </h2>

                <div className="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    {products.map((product) => (
                        <ProductItem key={product.id} {...product} />
                    ))}
                </div>
            </div>
        </div>
    );
}
