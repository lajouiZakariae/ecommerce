import axios from "axios";
import { useMutation, useQueryClient } from "react-query";
import { Link } from "react-router-dom";

export default function ProductItem({ id, title }) {
    const queryClient = useQueryClient();

    const { mutate } = useMutation(() => axios.delete(`/api/products/${id}`), {
        onSuccess: () => queryClient.invalidateQueries("products"),
    });

    return (
        <div className="col-6 mb-4" key={id}>
            <article className="card">
                <div className="card-body">
                    <h6>{title}</h6>
                </div>
                <div className="card-footer">
                    <Link to={`/products/${id}/edit`} className="btn btn-dark">
                        Edit
                    </Link>
                    <button className="btn btn-danger ms-2" onClick={mutate}>
                        Delete
                    </button>
                </div>
            </article>
        </div>
    );
}
