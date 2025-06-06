import { validationRules } from '@admin/common/utils/validationRules';
import { useForm } from 'react-hook-form';
import InputPassword from '@/admin/components/form/controls/InputPassword';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import React from 'react';
import { ProfileSecurityFormData } from '@admin/modules/profile/interfaces/ProfileSecurityFormData';
import { useNotification } from '@admin/common/context/NotificationContext';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';
import { useUser } from '@admin/common/context/UserContext';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import { HttpMethod } from '@admin/common/enums/httpEnums';


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
        onSuccess: ({ message }) => {
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
                    <>
                        <InputPassword
                            id="password"
                            label="Hasło"
                            hasError={!!fieldErrors?.password}
                            errorMessage={fieldErrors?.password?.message}
                            {...register('password', {
                                ...validationRules.required(),
                                ...validationRules.password(),
                            })}
                        />
                        <InputPassword
                            id="password-confirmation"
                            label="Powtórz hasło"
                            hasError={!!fieldErrors?.passwordConfirmation}
                            errorMessage={fieldErrors?.passwordConfirmation?.message}
                            {...register('passwordConfirmation', {
                                ...validationRules.required(),
                                validate(passwordConfirmation, { password }) {
                                    return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                                },
                            })}
                        />
                    </>
                </FormApiLayout>
            </FormWrapper>
        </>
    );
};

export default ProfileSecurityForm;
