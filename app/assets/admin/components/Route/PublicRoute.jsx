import { Navigate } from 'react-router-dom';
import {useAuth} from "@/admin/hooks/useAuth";

const PublicRoute = ({ component, redirectOnAuthSuccess}) => {
    const { isAuthenticated } = useAuth();

    if (isAuthenticated && redirectOnAuthSuccess) {
        return <Navigate to={redirectOnAuthSuccess} replace />;
    }

    return component;
};

export default PublicRoute;
