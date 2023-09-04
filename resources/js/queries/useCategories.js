import axios from "axios";
import { useQuery } from "react-query";

export function useCategories() {
    const query = useQuery(
        "categories",
        () =>
            axios.get("/api/categories").then(({ data }) => {
                console.log("Fetched...");
                return data;
            }),
        { refetchOnWindowFocus: false }
    );

    return {
        categories: query.data,
        categoriesError: query.error,
        isCategoriesLoading: query.isLoading,
    };
}
