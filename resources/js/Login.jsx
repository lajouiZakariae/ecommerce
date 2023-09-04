import { useEffect } from "react";
import { useAtom, useSetAtom } from "jotai";
import userAtom from "./atoms/user";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { useMutation } from "react-query";

async function doLogin(credentails) {
    const response = await axios.get("/sanctum/csrf-cookie");
    return response.status === 204
        ? await axios.post("/login", credentails)
        : null;
}

export default function Login() {
    const setUser = useSetAtom(userAtom);
    const navigate = useNavigate();

    const { mutate } = useMutation((credentails) => doLogin(credentails), {
        onSuccess: (data) => {
            setUser(data);
            return navigate("/dashboard/");
        },
    });

    return (
        <div>
            <form
                onSubmit={(ev) => {
                    ev.preventDefault();
                    mutate({
                        email: "user@one.com",
                        password: "password",
                    });
                }}
            ></form>
            <h2>Login</h2>
        </div>
    );
}
