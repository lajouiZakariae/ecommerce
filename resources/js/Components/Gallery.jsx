import { useState } from "react";
import { ColorBox } from "../routes/Products/edit";

export default function Gallery({ colors }) {
    const [colorTab, setColorTab] = useState(
        colors.length ? colors[0].hex : null
    );

    return (
        <div>
            <div className="flex flex-wrap">
                {colors.map(({ hex }) => (
                    <ColorBox
                        key={hex}
                        hex={hex}
                        onClick={() => setColorTab(hex)}
                    />
                ))}
            </div>
            <div className="flex flex-wrap">
                {colors
                    .find((color) => color.hex === colorTab)
                    ?.media.map(({ id, url }) => (
                        <div key={id} className="basis-1/3 px-2 py-2">
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
    );
}