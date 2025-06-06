import { FC, useEffect, useState } from 'react';
import AuthenticationWrapper from '@admin/modules/authentication/components/AuthenticationWrapper';
import ResetPasswordForm from '@admin/modules/authentication/components/form/ResetPasswordForm';
import { useLocation, useNavigate } from 'react-router-dom';
import SuspenseFallback from '@admin/pages/SuspenseFallback';

const ResetPassword: FC = () => {
    const [token, setToken] = useState<string>('');
    const [isComponentReady, setIsComponentReady] = useState<boolean>(false);
    const location = useLocation();
    const navigate = useNavigate();

    useEffect(() => {
        const params = new URLSearchParams(location.search);
        const currentToken = params.get('token');
        if (!currentToken) {
            navigate('/admin/public/login', { replace: true });
        }

        setToken(currentToken as string);
        setIsComponentReady(true);
    }, []);

    if (!isComponentReady) {
        return <SuspenseFallback />;
    }

    return (
        <AuthenticationWrapper title="Zresetuj hasło">
            <ResetPasswordForm token={token}  />
        </AuthenticationWrapper>
    )
}


export default ResetPassword;
