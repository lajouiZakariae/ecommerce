import axios from "axios";
import { useMutation, useQuery, useQueryClient } from "react-query";

export default function Media() {
    const queryClient = useQueryClient();

    const { isLoading, data } = useQuery("media", () =>
        axios.get("/api/media").then(({ data }) => data)
    );

    const { mutate, isError, error } = useMutation(
        (ev) => {
            ev.preventDefault();
            return axios.post("/api/media", new FormData(ev.target));
        },
        {
            onError: ({ response: { data } }) => {
                return data;
            },
            onSuccess: ({ data }) => {
                queryClient.invalidateQueries("media");
                console.log(data);
            },
        }
    );

    if (isLoading) {
        return <h1>Loading</h1>;
    }

    return (
        <div>
            <form onSubmit={mutate} className="mt-2">
                <input type="file" name="image" />
                <input type="submit" value="Upload" />
                <p className="text-danger">
                    {isError ? error.response.data.message : null}
                </p>
            </form>
            <div className="photos row mx-0 mt-2">
                {data.map(({ path, id }) => (
                    <div key={id} className="col-4 px-0">
                        <img src={path} className="w-100" alt="" />
                    </div>
                ))}
            </div>
        </div>
    );
}
