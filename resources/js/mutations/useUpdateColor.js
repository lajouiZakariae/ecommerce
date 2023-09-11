import axios from "axios";
import { useAtom, useAtomValue, useSetAtom } from "jotai";
import { useMutation, useQueryClient } from "react-query";
import actionsStack from "../atoms/actionsStack";

export default function useUpdateColor(colorId, setIsEdit) {
    const queryClient = useQueryClient();
    const [value, dispatch] = useAtom(actionsStack);

    const mutation = useMutation(
        ({ color }) => axios.put(`/api/colors/${colorId}`, color),
        {
            onSuccess: ({ data }, { color, action }) => {
                if (!action) {
                    const oldColor = queryClient
                        .getQueryData("colors")
                        .find((color) => color.id === colorId);
                    dispatch({
                        type: "ADD_ACTION",
                        payload: {
                            redo: () =>
                                mutation.mutate({ color, action: true }),
                            undo: () => {
                                console.log(oldColor);
                                mutation.mutate({
                                    color: oldColor,
                                    action: true,
                                });
                            },
                        },
                    });
                }

                queryClient.setQueryData("colors", (colors) =>
                    colors.map((color) => (color.id === colorId ? data : color))
                );

                setIsEdit(false);
            },
        }
    );
    return {
        isUpdateLoading: mutation.isLoading,
        updateMutate: mutation.mutate,
    };
}
