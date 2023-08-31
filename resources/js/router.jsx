import { createBrowserRouter } from "react-router-dom";
import Login from "./Login";
import Products from "./Products";
import Product from "./Products/show";
import EditProduct from "./Products/edit";
import AddProduct from "./Products/Add";
import Colors from "./colors";
import Media from "./media";
import Layout from "./Layout";

export default createBrowserRouter([
    {
        path: "/dashboard",
        element: <Layout />,
        errorElement: <h2>Not Found!</h2>,
        children: [
            {
                path: "login",
                Component: Login,
            },
            {
                path: "products",
                Component: Products,
            },
            {
                path: "products/:id",
                Component: Product,
            },
            {
                path: "products/:id/edit",
                Component: EditProduct,
            },
            {
                path: "products/create",
                Component: AddProduct,
            },
            {
                path: "colors",
                Component: Colors,
            },
            {
                path: "categories/:id",
                Component: Products,
            },
            {
                path: "media",
                Component: Media,
            },
        ],
    },
]);
