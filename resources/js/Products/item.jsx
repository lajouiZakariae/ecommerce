import axios from "axios";
import { useMutation, useQueryClient } from "react-query";
import { Link } from "react-router-dom";
import { ColorBox } from "./edit";

export default function ProductItem({ id, title, price, colors }) {
    const queryClient = useQueryClient();

    const { mutate } = useMutation(() => axios.delete(`/api/products/${id}`), {
        onSuccess: () => queryClient.invalidateQueries("products"),
    });
    return (
        <div className="group relative">
            <div className="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                <img
                    // src={product.imageSrc}
                    // alt={product.imageAlt}
                    className="h-full w-full object-cover object-center lg:h-full lg:w-full"
                />
            </div>
            <div className="mt-4 flex justify-between">
                <div>
                    <h3 className="text-sm text-gray-700">
                        <a href={`/products/${id}`}>
                            <span
                                aria-hidden="true"
                                className="absolute inset-0"
                            />
                            {title}
                        </a>
                    </h3>
                    <p className="mt-1 text-sm text-gray-500">
                        {colors?.map(({ name }) => name)}
                    </p>
                </div>
                <p className="text-sm font-medium text-gray-900">{price}</p>
            </div>
        </div>
    );
}
