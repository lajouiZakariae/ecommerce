import useUpdateColor from "../../mutations/useUpdateColor";
import useDeleteColor from "../../mutations/useDeleteColor";
import { useState } from "react";

export default function Color({ id, name, hex }) {
    const [isEdit, setIsEdit] = useState(false);
    const [color, setColor] = useState({ name, hex });

    const { deleteMutate, isDeleteLoading } = useDeleteColor(id);

    const { updateMutate } = useUpdateColor(id, setIsEdit);

    return (
        <tr key={id}>
            <td>
                {isEdit ? (
                    <input
                        type="text"
                        className="py-1 px-2 border border-gray-400"
                        value={color.name}
                        onChange={(ev) =>
                            setColor((prev) => ({
                                ...prev,
                                name: ev.target.value,
                            }))
                        }
                    />
                ) : (
                    name
                )}
            </td>

            <td>
                {isEdit ? (
                    <input
                        type="color"
                        value={color.hex}
                        onChange={(ev) =>
                            setColor((prev) => ({
                                ...prev,
                                hex: ev.target.value,
                            }))
                        }
                    />
                ) : (
                    <div
                        style={{
                            width: "50px",
                            height: "30px",
                            backgroundColor: hex,
                        }}
                    ></div>
                )}
            </td>

            <td>
                {isEdit ? (
                    <button
                        className="bg-green-600 ms-2 py-1 px-2 rounded text-white transition hover:bg-green-700 disabled:opacity-70"
                        onClick={() => updateMutate({ color, action: false })}
                    >
                        Save
                    </button>
                ) : (
                    <button
                        className="bg-blue-600 ms-2 py-1 px-2 rounded text-white transition hover:bg-blue-700 disabled:opacity-70"
                        onClick={() => setIsEdit(true)}
                    >
                        Edit
                    </button>
                )}
                <button
                    className="bg-red-600 ms-2 py-1 px-2 rounded text-white transition hover:bg-red-700 disabled:opacity-70"
                    disabled={isDeleteLoading}
                    onClick={() => deleteMutate(id)}
                >
                    Delete
                </button>
            </td>
        </tr>
    );
}
