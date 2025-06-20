import { validationRules } from '@admin/common/utils/validationRules';
import { useForm } from 'react-hook-form';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import React from 'react';
import { ProfileSecurityFormData } from '@admin/modules/profile/interfaces/ProfileSecurityFormData';
import { useNotification } from '@admin/common/context/NotificationContext';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';
import { useUser } from '@admin/common/context/UserContext';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import InputPassword from '@admin/common/components/form/input/InputPassword';
import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import PasswordFields from '@admin/common/components/form/fields/PasswordFields';

const ProfileSecurityForm: React.FC = () => {
    const {
        register,
        handleSubmit,
        setError,
        formState: { errors: fieldErrors },
    } = useForm<ProfileSecurityFormData>({
        mode: 'onBlur',
    });
    const { user } = useUser();
    const { addNotification } = useNotification();

    const apiRequestCallbacks = {
        onSuccess: ({ message }: { message: string }) => {
            addNotification(message, NotificationType.SUCCESS);
        },
    };

    return (
        <>
            <FormWrapper
                method={HttpMethod.PUT}
                endpoint={`admin/profiles/${user.id}/security`}
                handleSubmit={handleSubmit}
                setError={setError}
                apiRequestCallbacks={apiRequestCallbacks}
            >
                <FormApiLayout>
                    <FormSection title="Bezpieczeństwo" useToggleContent={false}>
                       <PasswordFields register={register} fieldErrors={fieldErrors} isEditMode={false} />
                    </FormSection>
                </FormApiLayout>
            </FormWrapper>
        </>
    );
};

export default ProfileSecurityForm;
