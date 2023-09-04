import axios from "axios";
import { useMutation, useQueryClient } from "react-query";
import { Link } from "react-router-dom";
import { ColorBox } from "./edit";

export default function ProductItem({ id, title, price, colors, thumbnail }) {
    const queryClient = useQueryClient();

    const { mutate } = useMutation(() => axios.delete(`/api/products/${id}`), {
        onSuccess: () => queryClient.invalidateQueries("products"),
    });

    return (
        <div className="group relative">
            <div className="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                <img
                    src={thumbnail?.path}
                    // alt={product.imageAlt}
                    className="h-full w-full object-cover object-center lg:h-full lg:w-full"
                />
            </div>
            <div className="mt-4 flex justify-between">
                <div>
                    <h3 className="text-sm text-gray-700">
                        <Link to={`/dashboard/products/${id}`}>
                            <span
                                aria-hidden="true"
                                className="absolute inset-0"
                            />
                            {title}
                        </Link>
                    </h3>
                    <div className="mt-1 text-sm text-gray-500 flex flex-wrap space-x-1">
                        {colors?.map(({ id, hex }) => (
                            <div
                                key={id}
                                className="h-4 w-4"
                                style={{ backgroundColor: hex }}
                            ></div>
                        ))}
                    </div>
                </div>
                <p className="text-sm font-medium text-gray-900">{price}</p>
            </div>
        </div>
    );
}
