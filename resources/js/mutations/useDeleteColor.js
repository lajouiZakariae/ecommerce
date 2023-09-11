import axios from "axios";
import { useMutation, useQueryClient } from "react-query";

export default function useDeleteColor(colorId) {
    const queryClient = useQueryClient();

    const mutation = useMutation((id) => axios.delete(`/api/colors/${id}`), {
        // onSuccess: () => queryClient.invalidateQueries("colors"),
        // Update Local Data
        onSuccess: (data) => {
            if (data.status === 204) {
                queryClient.setQueryData("colors", (colors) =>
                    colors.filter((color) => color.id !== colorId)
                );
            }
        },
    });

    return {
        deleteMutate: mutation.mutate,
        isDeleteLoading: mutation.isLoading,
    };
}
