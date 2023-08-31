import { useEffect } from "react";
import Navbar from "./Navbar";
import { Outlet } from "react-router-dom";
import userAtom from "./atoms/user";
import { useSetAtom } from "jotai";
import axios from "axios";
import { useQuery } from "react-query";

export default function Layout() {
    const setUser = useSetAtom(userAtom);

    const { data, isLoading } = useQuery("user", () => axios.get("/api/user"), {
        onSuccess: (data) => {
            // if (data.status === 401) {

            // }
            setUser(data.data);
        },
    });

    if (isLoading) {
        return "Big Fat Spinner...";
    }

    return (
        <div className="flex font-mono">
            <div className="basis-2/12 h-screen bg-slate-950">
                <Navbar />
            </div>
            <div className="basis-10/12 px-5">
                <Outlet />
            </div>
        </div>
    );
}
