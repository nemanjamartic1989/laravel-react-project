import { Navigate, Outlet, Link, useNavigate } from 'react-router-dom'
import { useStateContext } from '../context/ContextProvider';
import axiosClient from "../axios-client.js";
import { useEffect } from "react";

export default function DefaultLayout() {
    const { user, token, setUser, setToken } = useStateContext();
    const navigate = useNavigate();

    const onLogout = (e) => {
        e.preventDefault();

        axiosClient.post('/logout')
            .then(() => {
                setUser({})
                setToken(null)
                navigate('/login');
            })
    }

    useEffect(() => {
        if (!token) return;

        axiosClient.get('/user')
            .then(({ data }) => {
                setUser(data)
            })
    }, [])

    if (!token) {
        return <Navigate to="/login" />
    }

    return (
        <div id="defaultLayout">
            <aside>
                <Link to="/dashboard">Dashboard</Link>
                <Link to="/users">Users</Link>
            </aside>
            <div className="content">
                <header>
                    <div>
                        Header
                    </div>
                    <div>
                        {user.name_with_role} &nbsp; &nbsp;
                        <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
                    </div>
                </header>
                <main>
                    <Outlet />
                </main>
            </div>
        </div>
    );
}