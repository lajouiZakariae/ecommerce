import axios from "axios";
import { useState } from "react";
import { useMutation, useQuery, useQueryClient } from "react-query";

function AddColorForm({ route }) {
    const queryClient = useQueryClient();
    const { mutate, isError } = useMutation(
        (ev) => {
            ev.preventDefault();
            return axios.post(route, new FormData(ev.target));
        },
        {
            onSuccess: ({ data }) => console.log(data), //queryClient.invalidateQueries("colors"),
        }
    );

    return (
        <form className="row" onSubmit={mutate} method="post">
            <div className="col-6">
                <input
                    type="text"
                    name="name"
                    className={"form-control" + (isError ? " is-invalid" : "")}
                    placeholder="Name of Color"
                />
            </div>
            <div className="col-2">
                <input type="color" name="hex" />
            </div>
            <div className="col-2">
                <button type="submit" className="btn btn-primary">
                    Add
                </button>
            </div>
        </form>
    );
}

function Color({ id, name, hex, route }) {
    const queryClient = useQueryClient();

    const [isEdit, setIsEdit] = useState(false);
    const [color, setColor] = useState({ name, hex });

    const { mutate: deleteMutate } = useMutation(
        (id) => axios.delete(`${route}/${id}`),
        {
            onSuccess: () => queryClient.invalidateQueries("colors"),
        }
    );

    const { mutate: updateMutate } = useMutation(
        () => axios.put(`${route}/${id}`, color),
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

export default function Colors() {
    const { data, isLoading, isError } = useQuery("colors", () =>
        axios.get("/api/colors").then(({ data }) => data)
    );

    if (isLoading) {
        return <h2>Loading...</h2>;
    }

    if (isError) {
        return <h2>Error</h2>;
    }

    return (
        <div className="mt-2">
            <AddColorForm route={data.route} />
            <table className="table ">
                <thead>
                    <tr>
                        <th>Color Name</th>
                        <th>Color Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {data.colors.map((color) => (
                        <Color route={data.route} key={color.id} {...color} />
                    ))}
                </tbody>
            </table>
        </div>
    );
}
