import axios from "axios";
import Color from "./item";
import { useMutation, useQuery, useQueryClient } from "react-query";

function useAddColor() {
    const queryClient = useQueryClient();
    return useMutation(
        (ev) => {
            ev.preventDefault();
            return axios.post("/api/colors", new FormData(ev.target));
        },
        {
            onSuccess: ({ data, status }) => {
                if (status === 201) {
                    queryClient.setQueryData("colors", (colors) => [
                        ...colors,
                        data,
                    ]);
                }
            }, //queryClient.invalidateQueries("colors"),
        }
    );
}

function AddColorForm() {
    const { mutate, isError } = useAddColor();

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

export default function Colors() {
    const { data, isLoading, isError, isFetching } = useQuery(
        "colors",
        () => axios.get("/api/colors").then(({ data }) => data),
        { refetchOnWindowFocus: false }
    );

    if (isLoading) {
        return <h2>Loading...</h2>;
    }

    if (isError) {
        return <h2>Error</h2>;
    }

    if (isFetching) {
        console.log("Fetching Colors....");
    }

    return (
        <div className="mt-2">
            <AddColorForm route={data.route} />
            <table className="table ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {data.map((color) => (
                        <Color key={color.id} {...color} />
                    ))}
                </tbody>
            </table>
        </div>
    );
}
