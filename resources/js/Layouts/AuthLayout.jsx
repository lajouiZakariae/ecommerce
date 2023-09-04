import { Outlet } from "react-router-dom";

export default function AuthLayout() {
    return (
        <div className="font-mono">
            <div className="bg-slate-950">Navbar</div>
            <div className="">
                <Outlet />
            </div>
        </div>
    );
}
