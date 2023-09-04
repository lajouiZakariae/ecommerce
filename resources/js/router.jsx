import { createBrowserRouter } from "react-router-dom";
import Login from "./Login";
import Products from "./routes/Products";
import Product from "./routes/Products/show";
import EditProduct from "./routes/Products/edit";
import AddProduct from "./routes/Products/Add";
import Colors from "./routes/colors";
import Media from "./routes/media";
import Layout from "./Layouts/Dashboard";
import AuthLayout from "./Layouts/AuthLayout";

export default createBrowserRouter([
    {
        path: "/dashboard/login",
        element: <AuthLayout />,
        children: [{ index: true, Component: Login }],
    },
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
