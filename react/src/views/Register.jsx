import { useContext, useRef } from "react";
import axiosClient from "../axios-client";

export default function Register() {
    const nameRef = useRef();
    const emailRef = useRef();
    const passwordRef = useRef();
    const passwordConfirmationRef = useRef();

    const {setUser, setToken} = useContext();

    const onSubmit = (e) => {
        e.preventDefault();

        const payload = {
            name: nameRef.current.value,
            email: emailRef.current.value,
            password: passwordRef.current.value,
            password_confirmation: passwordConfirmationRef.current.value
        };

        axiosClient.post('/signup', payload)
            .then(({data}) => {
                setUser(data.user);
                setToken(data.token);
            }).catch(err => {
                const response = err.response;

                if (response && response.status === 422) {
                    console.log(response.data.errors);
                }
            });
    }

    return (
        <div className="login-signup-form animated fadeInDown">
            <div className="form">
                <form onSubmit={onSubmit}>
                    <h1 className="form">
                        Sign Up for free
                    </h1>
                    <input type="text" name="name" ref={nameRef} placeholder="Full Name"/>
                    <input type="email" name="email" ref={emailRef} placeholder="Email"/>
                    <input type="password" name="password" ref={passwordRef} placeholder="Password"/>
                    <input type="password" name="password_confirmation" ref={passwordConfirmationRef} placeholder="Password Confirmation"/>
                    <button className="btn btn-block">Sign Up</button>
                    <p classname="message">
                        Already Registered? <Link to="/login">Sign in</Link>
                    </p>
                </form>
            </div>
        </div>
    );
}