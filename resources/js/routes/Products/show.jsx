import axios from "axios";
import { useQuery } from "react-query";
import { Link, useParams } from "react-router-dom";
import Gallery from "../../Components/Gallery";

function useProduct(id) {
    return useQuery({
        queryKey: ["products", id],
        queryFn: async ({ queryKey }) => {
            const { data } = await axios.get(`/api/products/${queryKey[1]}`);
            return data;
        },
        refetchOnWindowFocus: false,
    });
}

function ColorBox({ hex }) {
    return <div className="h-9 w-9" style={{ backgroundColor: hex }}></div>;
}

export default function Product() {
    const { id } = useParams();

    const { data: product, isError, isLoading } = useProduct(id);

    if (isLoading) {
        return <h2>Loading...</h2>;
    }

    if (isError) {
        return <h2>Error</h2>;
    }

    console.log(product);
    return (
        <div className="card mt-2">
            <div className="card-body">
                <h3 className="font-bold capitalize">{product.title}</h3>
                <p>
                    category:{" "}
                    <Link to={`/categories/${product.category.id}`}>
                        {product.category.name}
                    </Link>
                </p>
                Available Colors:
                <div className="flex flex-wrap space-x-2">
                    <Gallery colors={product.colors} />
                </div>
            </div>
        </div>
    );
}
