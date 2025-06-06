import { ReactNode } from 'react';
import { Navigate } from 'react-router-dom';
import { useUser } from '@admin/common/context/UserContext';

interface ProtectedRouteProps {
    children: ReactNode;
    requiredRoles: string[];
}

const ProtectedRoute = ({ children, requiredRoles }: ProtectedRouteProps) => {
    const { user } = useUser();

    // if (!requiredRoles.every((requiredRole) => user?.roles?.includes(requiredRole))) {
    //     return <Navigate to="/admin/forbidden" replace />;
    // }

    return <>{children}</>;
};

export default ProtectedRoute;
