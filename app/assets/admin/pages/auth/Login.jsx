import LoginForm from '@/admin/features/auth/components/LoginForm';
import AuthWrapper from '@/admin/pages/auth/AuthWrapper';

const Login = () => {
    return (
        <AuthWrapper title="Zaloguj się">
            <LoginForm />
        </AuthWrapper>
    );
};

export default Login;
