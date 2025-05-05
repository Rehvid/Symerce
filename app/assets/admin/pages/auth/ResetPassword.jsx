import { useEffect, useState } from 'react';
import ResetPasswordForm from '@/admin/features/auth/components/ResetPasswordForm';
import { useLocation, useNavigate } from 'react-router-dom';
import AuthWrapper from '@/admin/pages/auth/AuthWrapper';
import SuspenseFallback from '@/admin/pages/SuspenseFallback';

const ResetPassword = () => {
    const [token, setToken] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const location = useLocation();
    const navigate = useNavigate();

    useEffect(() => {
        const params = new URLSearchParams(location.search);
        const currentToken = params.get('token');
        if (!currentToken) {
            navigate('/admin/public/login', { replace: true });
        }

        setToken(currentToken);
        setIsLoading(false);
    }, []);

    if (isLoading) {
        return <SuspenseFallback />;
    }

    return (
        <AuthWrapper title="Zresetuj hasło">
            <ResetPasswordForm token={token} />
        </AuthWrapper>
    );
};

export default ResetPassword;
