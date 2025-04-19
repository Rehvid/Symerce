import { validationRules } from '@/admin/utils/validationRules';
import React from 'react';
import { useForm } from 'react-hook-form';
import { useUser } from '@/admin/hooks/useUser';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import ApiForm from '@/admin/components/form/ApiForm';
import { createApiConfig } from '@/shared/api/ApiConfig';
import InputPassword from '@/admin/components/form/controls/InputPassword';
import FormLayout from '@/admin/layouts/FormLayout';

const ProfileSecurityForm = () => {
    const {
        register,
        handleSubmit,
        setError,
        formState: { errors: fieldErrors },
    } = useForm({
        mode: 'onBlur',
    });
    const { user } = useUser();
    const { addNotification } = useCreateNotification();

    const apiRequestCallbacks = {
        onSuccess: ({ message }) => {
            addNotification(message, ALERT_TYPES.SUCCESS);
        },
    };

    return (
        <>
            <ApiForm
                apiConfig={createApiConfig(`admin/profiles/${user.id}/security`, HTTP_METHODS.PUT)}
                handleSubmit={handleSubmit}
                setError={setError}
                apiRequestCallbacks={apiRequestCallbacks}
            >
                <FormLayout
                    mainColumn={
                        <>
                            <InputPassword
                                id="password"
                                label="Hasło"
                                hasError={fieldErrors.hasOwnProperty('password')}
                                errorMessage={fieldErrors?.password?.message}
                                {...register('password', {
                                    ...validationRules.required(),
                                    ...validationRules.password(),
                                })}
                            />
                            <InputPassword
                                id="password-confirmation"
                                label="Powtórz hasło"
                                hasError={fieldErrors.hasOwnProperty('passwordConfirmation')}
                                errorMessage={fieldErrors?.passwordConfirmation?.message}
                                {...register('passwordConfirmation', {
                                    ...validationRules.required(),
                                    validate: function (passwordConfirmation, { password }) {
                                        return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                                    },
                                })}
                            />
                        </>
                    }
                />
            </ApiForm>
        </>
    );
};

export default ProfileSecurityForm;
