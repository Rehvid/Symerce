import { Navigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

function PrivateRoute({ component, redirectOnAuthFailure, redirectOnAuthSuccess }) {
    const { isAuthenticated, loading } = useAuth();

    if (loading) {
        return <div>Loading...</div>;
    }

    if (!isAuthenticated && redirectOnAuthFailure) {
        return <Navigate to={redirectOnAuthFailure} replace />;
    }

    if (isAuthenticated && redirectOnAuthSuccess) {
        return <Navigate to={redirectOnAuthSuccess} replace />;
    }

    return component;
}

export default PrivateRoute;
