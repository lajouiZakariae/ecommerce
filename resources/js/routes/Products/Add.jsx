import Input, { FormGroup } from "../../Components/Input";
import { useRef, useState } from "react";
import { useCategories } from "../../queries/useCategories";
import useCreateProduct from "../../mutations/useCreateProduct";
import { useColors } from "../../queries/useColors";
import { ColorBox } from "./edit";

function Tab({ onClick, children, activeTab }) {
    return (
        <div
            className={`basis-1/2 mt-1 py-2 rounded-t-lg transition cursor-pointer${
                activeTab ? " bg-slate-950 text-white" : ""
            }`}
            onClick={onClick}
        >
            {children}
        </div>
    );
}

export default function AddProduct() {
    const { categories, isCategoriesLoading, categoriesError } =
        useCategories();

    const { colors, colorsError, isColorsLoading } = useColors();

    const { mutate, isLoading, isError, error } = useCreateProduct();

    const [tab, setTab] = useState(2);

    const [choosedColor, setChoosedColor] = useState("#ffffff");
    const [imagespreview, setImagesPreview] = useState([]);

    const [product, setProduct] = useState({
        title: `Product number ${Math.random() * 1000}`,
        description: "",
        cost: 0,
        quantity: 0,
        price: 0,
        category: 0,
        colors: [],
    });

    console.log(product);

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

            <form className="mt-3" onSubmit={(ev) => mutate({ ev, product })}>
                {tab === 1 && (
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
                            {isCategoriesLoading ? (
                                <p className="">Loading Categories...</p>
                            ) : categoriesError ? (
                                <p className="text-danger-500">Error...</p>
                            ) : (
                                <FormGroup
                                    label={
                                        <label htmlFor="category">
                                            Category
                                        </label>
                                    }
                                >
                                    <select
                                        onChange={(ev) =>
                                            setProduct((prev) => ({
                                                ...prev,
                                                category: ev.value,
                                            }))
                                        }
                                        id="category"
                                    >
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
                )}

                {tab === 2 && (
                    <div>
                        <div className="flex flex-wrap">
                            <div
                                key={"add-box"}
                                className="basis-1/3 px-2 py-2"
                            >
                                <div>
                                    {isColorsLoading ? (
                                        <h2>Loading Colors...</h2>
                                    ) : colorsError ? (
                                        <h2>Error..</h2>
                                    ) : (
                                        <select id="" className="w-full">
                                            {colors.map(({ id, hex, name }) => (
                                                <option
                                                    key={id}
                                                    value={hex}
                                                    style={{
                                                        backgroundColor: hex,
                                                    }}
                                                    className="focus:bg-none hover:bg-none"
                                                >
                                                    {name}
                                                </option>
                                            ))}
                                        </select>
                                    )}
                                </div>
                                <div
                                    onClick={() => fileInput.current.click()}
                                    className="flex justify-center items-center h-36 bg-gray-200 hover:bg-gray-100 transition"
                                >
                                    Add Image
                                </div>
                            </div>

                            <>
                                <input
                                    type="file"
                                    name="images"
                                    ref={fileInput}
                                    hidden
                                    onChange={(ev) => {
                                        const fileReader = new FileReader();

                                        fileReader.readAsDataURL(
                                            ev.target.files[0]
                                        );

                                        fileReader.onload = (data) => {
                                            const imgAsUrl =
                                                data.currentTarget.result;

                                            setProduct((prev) => ({
                                                ...prev,
                                                colors: prev.colors.find(
                                                    (color) =>
                                                        color.hex ===
                                                        choosedColor
                                                )
                                                    ? // Found
                                                      prev.colors.map((color) =>
                                                          color.hex ===
                                                          choosedColor
                                                              ? {
                                                                    ...color,
                                                                    images: [
                                                                        ...color.images,
                                                                        ev
                                                                            .target
                                                                            .files[0],
                                                                    ],
                                                                }
                                                              : color
                                                      )
                                                    : //  New
                                                      [
                                                          ...prev.colors,
                                                          {
                                                              hex: choosedColor,
                                                              images: [
                                                                  ev.target
                                                                      .files[0],
                                                              ],
                                                          },
                                                      ],
                                            }));

                                            setChoosedColor("#ffffff");

                                            setImagesPreview((prev) => [
                                                ...prev,
                                                {
                                                    url: imgAsUrl,
                                                },
                                            ]);
                                        };
                                    }}
                                />
                            </>

                            {imagespreview.map(({ url }) => (
                                <div key={url} className="basis-1/3 px-2 py-2">
                                    <div className="flex justify-center items-center h-36 bg-gray-200 hover:bg-gray-100 transition">
                                        <img
                                            src={url}
                                            className="h-full w-full object-cover rounded-md"
                                        />
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                )}

                <button className="py-1.5 px-3 bg-blue-400">Add</button>
            </form>
        </>
    );
}
