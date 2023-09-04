import { useEffect } from "react";
import Navbar from "../Navbar";
import { Outlet, redirect, useNavigate } from "react-router-dom";
import userAtom from "../atoms/user";
import { useSetAtom } from "jotai";
import axios from "axios";
import { useQuery } from "react-query";

export default function Layout() {
    const navigate = useNavigate();
    const setUser = useSetAtom(userAtom);

    const { data, isLoading } = useQuery("user", () => axios.get("/api/user"), {
        onSuccess: (data) => {
            if (data.status === 401) {
                navigate("/dashboard/login");
            }
            setUser(data);
        },
    });

    if (isLoading) {
        return "Big Fat Spinner...";
    }

    return (
        <div className="font-mono">
            <div className="h-screen w-44 fixed left-0 top-0 bg-slate-950">
                <Navbar />
            </div>
            <div className="ml-44 px-5">
                <Outlet />
            </div>
        </div>
    );
}
