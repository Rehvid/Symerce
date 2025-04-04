import { Navigate } from 'react-router-dom';
import { useAuth } from '@/admin/hooks/useAuth';
import { useEffect } from 'react';
import { useUser } from '@/admin/hooks/useUser';

const ProtectedRoute = ({ children, requiredRoles, redirectOnAuthFailure = '/admin/public/login' }) => {
    const { isLoadingAuthorization, verifyAuth } = useAuth();
    const { isAuthenticated, user } = useUser();
    useEffect(() => {
        verifyAuth();
    }, []);

    if (isLoadingAuthorization) {
        return <>...Loading</>;
    }

    if (!isAuthenticated && redirectOnAuthFailure) {
        return <Navigate to={redirectOnAuthFailure} replace />;
    }

    if (!requiredRoles.every((requiredRole) => user.roles.includes(requiredRole))) {
        return <Navigate to={'/admin/forbidden'} replace />;
    }

    return children;
};

export default ProtectedRoute;
