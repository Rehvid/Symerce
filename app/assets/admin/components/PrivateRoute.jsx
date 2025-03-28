import { Navigate } from 'react-router-dom';
import {useAuth} from "@/admin/hooks/useAuth";

const PrivateRoute = ({ component, redirectOnAuthFailure, redirectOnAuthSuccess }) => {
    const { isAuthenticated } = useAuth();

    if (!isAuthenticated && redirectOnAuthFailure) {
        return <Navigate to={redirectOnAuthFailure} replace />;
    }

    if (isAuthenticated && redirectOnAuthSuccess) {
        return <Navigate to={redirectOnAuthSuccess} replace />;
    }

    return component;
};

export default PrivateRoute;
