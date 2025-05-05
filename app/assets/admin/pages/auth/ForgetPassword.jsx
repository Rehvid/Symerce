import ForgotPasswordForm from '@/admin/features/auth/components/ForgetPasswordForm';
import AuthWrapper from '@/admin/pages/auth/AuthWrapper';

const ForgetPassword = () => {
    return (
        <AuthWrapper title="Przypomnij Hasło">
            <ForgotPasswordForm />
        </AuthWrapper>
    );
};

export default ForgetPassword;
