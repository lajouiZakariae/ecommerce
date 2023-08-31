import { useEffect } from "react";
import { useAtom } from "jotai";
import userAtom from "./atoms/user";
import axios from "axios";

export default function Login() {
    const [user, setUser] = useAtom(userAtom);

    useEffect(() => {
        axios.get("/sanctum/csrf-cookie").then((response) => {
            console.log("CSRF: ", response);

            axios
                .post("/login", {
                    email: "user@one.com",
                    password: "password",
                })
                .then((resp) => {
                    setUser(resp.data);
                    console.log(resp);
                });
        });
    }, []);

    return (
        <div>
            <h2>Hello {user?.name}</h2>
        </div>
    );
}
