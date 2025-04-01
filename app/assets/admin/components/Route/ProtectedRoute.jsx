import {Navigate} from 'react-router-dom';
import {useAuth} from "@/admin/hooks/useAuth";
import {useEffect } from "react";

const ProtectedRoute = ({ children, requiredRoles, redirectOnAuthFailure = '/admin/login' }) => {
    const { isAuthenticated, user, isLoadingAuthorization, verifyAuth } = useAuth();
    const { roles } = user;

    useEffect(() => {
        verifyAuth();
    }, []);

    if (isLoadingAuthorization) {
        return <>...Loading</>
    }

    if (!isAuthenticated && redirectOnAuthFailure) {
        return <Navigate to={redirectOnAuthFailure} replace />;
    }

    if (!requiredRoles.every(requiredRole => roles.includes(requiredRole))) {
        return <Navigate to={'/admin/forbidden'} replace />
    }

    return children
};

export default ProtectedRoute;
