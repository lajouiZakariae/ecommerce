import { Link, useLocation } from "react-router-dom";

export function NavBarLink({ href, text }) {
    const { pathname } = useLocation();
    const isCurrentRoute = pathname === href;
    return (
        <Link
            to={href}
            className={`w-full px-1 py-2 font-semibold text-center rounded-md mb-2 transition inline-block ${
                isCurrentRoute
                    ? "text-cyan-600"
                    : "text-gray-50 hover:text-cyan-500"
            }`}
        >
            {text}
        </Link>
    );
}

export default function Navbar() {
    return (
        <ul className="text-white p-2">
            <li>
                <NavBarLink text={"Products"} href={"/products"} />
            </li>
            <li>
                <NavBarLink text={"Colors"} href={"/colors"} />
            </li>
            <li>
                <NavBarLink text={"Media"} href={"/media"} />
            </li>
        </ul>
    );
}
