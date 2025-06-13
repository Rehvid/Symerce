import { FC } from 'react';
import AuthenticationWrapper from '@admin/modules/authentication/components/AuthenticationWrapper';
import LoginForm from '@admin/modules/authentication/components/form/LoginForm';

const Login: FC = () => {
    return (
        <AuthenticationWrapper title="Witaj ponownie, zaloguj się">
            <LoginForm />
        </AuthenticationWrapper>
    );
};

export default Login;
