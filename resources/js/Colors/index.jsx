import axios from "axios";
import Color from "./item";
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
