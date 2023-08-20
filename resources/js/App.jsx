// import "bootstrap/dist/css/bootstrap.min.css";
// import "bootstrap/dist/js/bootstrap.bundle";
import { Outlet, RouterProvider, createBrowserRouter } from "react-router-dom";
import { QueryClient, QueryClientProvider } from "react-query";
import Navbar from "./Navbar";
import Products from "./Products";
import Colors from "./colors";
import Product from "./Products/show";
import EditProduct from "./Products/edit";
import AddProduct from "./Products/Add";
import Media from "./media";

const queryClient = new QueryClient();

const router = createBrowserRouter([
    {
        path: "/",
        element: <Root />,
        errorElement: <h2>Not Found!</h2>,
        children: [
            {
                path: "/products",
                Component: Products,
            },
            {
                path: "/products/:id",
                Component: Product,
            },
            {
                path: "/products/:id/edit",
                Component: EditProduct,
            },
            {
                path: "/products/create",
                Component: AddProduct,
            },
            {
                path: "/colors",
                Component: Colors,
            },
            {
                path: "/categories/:id",
                Component: Products,
            },
            {
                path: "/media",
                Component: Media,
            },
        ],
    },
]);

function Root() {
    return (
        <QueryClientProvider client={queryClient}>
            <div className="flex font-mono">
                <div className="basis-2/12 h-screen bg-slate-950">
                    <Navbar />
                </div>
                <div className="basis-10/12 px-5">
                    <Outlet />
                </div>
            </div>
        </QueryClientProvider>
    );
}

export default function App() {
    return <RouterProvider router={router} />;
}
