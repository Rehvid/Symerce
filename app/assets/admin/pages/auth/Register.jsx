import RegisterForm from '@/admin/features/auth/components/RegisterForm';
import AuthWrapper from '@/admin/pages/auth/AuthWrapper';

const Register = () => {
    return (
        <AuthWrapper title="Zarejestruj się">
            <RegisterForm />
        </AuthWrapper>
    );
};

export default Register;
