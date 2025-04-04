import Card from '@/admin/components/Card';
import React, { useEffect, useState } from 'react';
import ResetPasswordForm from '@/admin/features/auth/components/ResetPasswordForm';
import { useLocation, useNavigate } from 'react-router-dom';

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
        return <>...Ładowanie</>;
    }

    return (
        <div className="container mx-auto my-auto py-8">
            <Card additionalClasses="max-w-md mx-auto shadow-lg">
                <h1 className="text-2xl font-bold py-5 mb-6 text-center ">Zresetuj hasło</h1>
                <ResetPasswordForm token={token} />
            </Card>
        </div>
    );
};

export default ResetPassword;
