import axios from "axios";
import { useQuery } from "react-query";

export function useColors() {
    const query = useQuery("colors", () =>
        axios.get("/api/colors").then(({ data }) => data)
    );

    return {
        colors: query.data,
        colorsError: query.error,
        isColorsLoading: query.isLoading,
    };
}
