import axios from "axios";
import { useState } from "react";
import { useMutation, useQueryClient } from "react-query";

export default function Color({ id, name, hex }) {
    const queryClient = useQueryClient();

    const [isEdit, setIsEdit] = useState(false);
    const [color, setColor] = useState({ name, hex });

    const { mutate: deleteMutate } = useMutation(
        (id) => axios.delete(`/api/colors/${id}`),
        {
            onSuccess: () => queryClient.invalidateQueries("colors"),
        }
    );

    const { mutate: updateMutate } = useMutation(
        () => axios.put(`/api/colors/${id}`, color),
        {
            onSuccess: () => {
                queryClient.invalidateQueries("colors");
                setIsEdit(false);
            },
        }
    );

    return (
        <tr key={id}>
            <td>
                {isEdit ? (
                    <input
                        type="text"
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
                        className="btn btn-success"
                        onClick={() => updateMutate()}
                    >
                        Save
                    </button>
                ) : (
                    <button
                        className="btn btn-dark"
                        onClick={() => setIsEdit(true)}
                    >
                        Edit
                    </button>
                )}
                <button
                    className="btn btn-danger ms-2"
                    onClick={() => deleteMutate(id)}
                >
                    Delete
                </button>
            </td>
        </tr>
    );
}
