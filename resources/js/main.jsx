import React from "react";
import { createRoot } from "react-dom/client";
import axios from "axios";
import { QueryClient, QueryClientProvider } from "react-query";
import router from "./router";
import { RouterProvider } from "react-router-dom";

axios.defaults.withCredentials = true;

const queryClient = new QueryClient();

const container = document.getElementById("root");

if (container) {
    const root = createRoot(container);
    root.render(
        <QueryClientProvider client={queryClient}>
            <RouterProvider router={router} />
        </QueryClientProvider>
    );
}
