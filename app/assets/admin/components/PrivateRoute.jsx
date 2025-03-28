import { Navigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const PrivateRoute = ({ component, redirectOnAuthFailure, redirectOnAuthSuccess }) => {
    const { isAuthenticated } = useAuth();

    if (!isAuthenticated && redirectOnAuthFailure) {
        return <Navigate to={redirectOnAuthFailure} replace />;
    }

    if (isAuthenticated && redirectOnAuthSuccess) {
        return <Navigate to={redirectOnAuthSuccess} replace />;
    }

    return component;
}

export default PrivateRoute;
