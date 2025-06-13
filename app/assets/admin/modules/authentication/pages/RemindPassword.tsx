import { FC } from 'react';
import AuthenticationWrapper from '@admin/modules/authentication/components/AuthenticationWrapper';
import RemindPasswordForm from '@admin/modules/authentication/components/form/RemindPasswordForm';

const RemindPassword: FC = () => {
    return (
        <AuthenticationWrapper title="Przypomnij hasło">
            <RemindPasswordForm />
        </AuthenticationWrapper>
    );
};

export default RemindPassword;
