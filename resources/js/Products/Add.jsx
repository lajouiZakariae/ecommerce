import axios from "axios";
import Input, { FormGroup } from "../Components/Input";
import { useQuery } from "react-query";
import { useRef, useState } from "react";

function Tab(props) {
    return (
        <div
            className={`basis-1/2 mt-1 py-2 rounded-t-lg transition cursor-pointer${
                props.activeTab ? " bg-slate-950 text-white" : ""
            }`}
            onClick={props.onClick}
        >
            {props.children}
        </div>
    );
}

export default function AddProduct() {
    const { data: categories, isLoading } = useQuery("categories", () =>
        axios.get("/api/categories").then(({ data }) => data)
    );

    const [tab, setTab] = useState(1);

    const [product, setProduct] = useState({
        title: "",
        cost: 0,
        price: 0,
        quantity: 0,
        category_id: null,
        images: [],
    });

    const fileInput = useRef();

    return (
        <>
            <div className="flex text-center">
                <Tab activeTab={tab === 1} onClick={() => setTab(1)}>
                    Information
                </Tab>
                <Tab activeTab={tab === 2} onClick={() => setTab(2)}>
                    Media
                </Tab>
            </div>
            <form className="mt-3">
                {tab === 1 ? (
                    <>
                        <FormGroup label={<label htmlFor="title">Title</label>}>
                            <Input
                                type="text"
                                id="title"
                                name="title"
                                placeholder="The quick brown fox jumps over the lazy dog"
                                value={product.title}
                                onChange={(ev) =>
                                    setProduct((prev) => ({
                                        ...prev,
                                        title: ev.target.value,
                                    }))
                                }
                            />
                        </FormGroup>
                        <FormGroup label={<label htmlFor="cost">Cost</label>}>
                            <Input
                                type="text"
                                id="cost"
                                name="cost"
                                placeholder="0.00 MAD"
                                value={product.cost}
                                onChange={(ev) =>
                                    setProduct((prev) => ({
                                        ...prev,
                                        cost: ev.target.value,
                                    }))
                                }
                            />
                        </FormGroup>
                        <FormGroup label={<label htmlFor="price">Price</label>}>
                            <Input
                                type="text"
                                id="price"
                                name="price"
                                placeholder="0.00 MAD"
                                value={product.price}
                                onChange={(ev) =>
                                    setProduct((prev) => ({
                                        ...prev,
                                        price: ev.target.value,
                                    }))
                                }
                            />
                        </FormGroup>
                        <FormGroup
                            label={<label htmlFor="quantity">Quantity</label>}
                        >
                            <Input
                                type="text"
                                id="quantity"
                                name="quantity"
                                placeholder="0"
                                value={product.quantity}
                                onChange={(ev) =>
                                    setProduct((prev) => ({
                                        ...prev,
                                        quantity: ev.target.value,
                                    }))
                                }
                            />
                        </FormGroup>

                        <div>
                            {isLoading ? (
                                <p className="">Loading Categories...</p>
                            ) : (
                                <FormGroup
                                    label={
                                        <label htmlFor="category">
                                            Category
                                        </label>
                                    }
                                >
                                    <select name="category_id" id="category">
                                        {categories.map(({ id, name }) => (
                                            <option key={id} value={id}>
                                                {name}
                                            </option>
                                        ))}
                                    </select>
                                </FormGroup>
                            )}
                        </div>
                    </>
                ) : null}
                {tab === 2 ? (
                    <div>
                        <input
                            type="file"
                            name="images"
                            ref={fileInput}
                            hidden
                            onChange={(ev) => {
                                const fileReader = new FileReader();

                                fileReader.readAsDataURL(ev.target.files[0]);

                                fileReader.onload = (data) => {
                                    const imgAsUrl = data.currentTarget.result;
                                    setProduct((prev) => ({
                                        ...prev,
                                        images: [...prev.images, imgAsUrl],
                                    }));
                                };
                            }}
                        />
                        <div className="flex flex-wrap">
                            <div className="basis-1/3 px-2 py-2">
                                <div
                                    className="flex justify-center items-center h-36 bg-gray-200 hover:bg-gray-100 cursor-pointer transition duration-500 rounded-md"
                                    onClick={() => fileInput.current.click()}
                                >
                                    Add
                                </div>
                            </div>
                            {product.images.map((image) => (
                                <div
                                    key={image}
                                    className="basis-1/3 px-2 py-2"
                                >
                                    <div className="flex justify-center items-center h-36 bg-gray-200 hover:bg-gray-100 transition">
                                        <img
                                            src={image}
                                            className="h-full w-full object-cover rounded-md"
                                        />
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                ) : null}
            </form>
        </>
    );
}
