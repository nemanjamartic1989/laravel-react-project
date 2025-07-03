import {Navigate, Outlet} from 'react-router-dom'
import { useStateContext } from '../context/Contextprovider';

export default function DefaultLayout() {
    const {user, token} = useStateContext();

    if (!token) {
        return <Navigate to="/login" />
    }

    return (
        <div>
            Default
            <Outlet />
        </div>
    );
}