import { Link, useNavigate } from "react-router-dom";
import axiosClient from "../axios-client.js";
import { useStateContext } from "../context/ContextProvider.jsx";
import { useState } from "react";

export default function Login() {
  const { setUser, setToken } = useStateContext();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [errors, setErrors] = useState(null);
  const [remember, setRemember] = useState(false);
  const navigate = useNavigate();

  const onSubmit = ev => {
    ev.preventDefault();

    const payload = { email, password };

    axiosClient.post('/login', payload)
      .then(({ data }) => {
        setUser(data.user);

        if (remember) {
          localStorage.setItem("ACCESS_TOKEN", data.token);
        } else {
          sessionStorage.setItem("ACCESS_TOKEN", data.token);
        }

        setToken(data.token);
        navigate('/user');
      })
      .catch((err) => {
        const response = err.response;
        if (response && response.status === 422) {
          setErrors(response.data.errors);
        }
      });
  }

  return (
    <div className="login-signup-form animated fadeInDown">
      <div className="form">
        <form onSubmit={onSubmit} autoComplete="on">
          <h1 className="title">Login into your account</h1>

          <input
            type="email"
            name="email"
            autoComplete="username"
            placeholder="Email"
            value={email}
            onChange={e => setEmail(e.target.value)}
          />
          {errors?.email && <span className="error">{errors.email[0]}</span>}

          <input
            type="password"
            name="password"
            autoComplete="current-password"
            placeholder="Password"
            value={password}
            onChange={e => setPassword(e.target.value)}
          />
          {errors?.password && <span className="error">{errors.password[0]}</span>}

          <div className='remember-me-box'>
            <input
              id="remember"
              type="checkbox"
              checked={remember}
              onChange={e => setRemember(e.target.checked)}
            />
            <label htmlFor="remember">
              Remember me
            </label>
          </div>

          <button className="btn btn-block">Login</button>
        </form>

      </div>
    </div>
  );
}
