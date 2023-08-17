import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle";
import { Outlet, RouterProvider, createBrowserRouter } from "react-router-dom";
import { QueryClient, QueryClientProvider } from "react-query";
import Navbar from "./Navbar";
import Products from "./Products";
import Colors from "./colors";
import Product from "./Products/show";
import EditProduct from "./Products/edit";

const queryClient = new QueryClient();

const router = createBrowserRouter([
    {
        path: "/",
        element: <Root />,
        errorElement: <h2>Not Found!</h2>,
        children: [
            { path: "/products", Component: Products },
            { path: "/products/:id", Component: Product },
            { path: "/products/:id/edit", Component: EditProduct },
            { path: "/colors", Component: Colors },
        ],
    },
]);

function Root() {
    return (
        <QueryClientProvider client={queryClient}>
            <div className="row m-0">
                <div className="col-3 m-0">
                    <Navbar />
                </div>
                <div className="col-9 m-0">
                    <Outlet />
                </div>
            </div>
        </QueryClientProvider>
    );
}

export default function App() {
    return <RouterProvider router={router} />;
}
