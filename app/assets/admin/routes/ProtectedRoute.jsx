import { Navigate } from 'react-router-dom';
import { useUser } from '@/admin/hooks/useUser';

const ProtectedRoute = ({ children, requiredRoles }) => {
    const { user } = useUser();


    // if (!requiredRoles.every((requiredRole) => user.roles.includes(requiredRole))) {
    //     return <Navigate to={'/admin/forbidden'} replace />;
    // }

    return children;
};

export default ProtectedRoute;
