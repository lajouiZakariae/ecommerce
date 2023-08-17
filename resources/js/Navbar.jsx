import { Link } from "react-router-dom";

export default function Navbar() {
    return (
        <ul className="nav flex-column text-center">
            <li className="nav-item">
                <Link to={"/products"} className="nav-link active">
                    Products
                </Link>
            </li>

            <li className="nav-item">
                <Link to={"/colors"} className="nav-link active">
                    Colors
                </Link>
            </li>

            <li className="nav-item">
                <a className="nav-link" href="#">
                    Link
                </a>
            </li>

            <li className="nav-item">
                <a className="nav-link disabled" href="#">
                    Disabled
                </a>
            </li>
        </ul>
    );
}
