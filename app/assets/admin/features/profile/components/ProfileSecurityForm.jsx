import { validationRules } from '@/admin/utils/validationRules';
import React from 'react';
import { useForm } from 'react-hook-form';
import { useUser } from '@/admin/hooks/useUser';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import AppInputPassword from '@/admin/components/form/AppInputPassword';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import AppForm from '@/admin/components/form/AppForm';
import { createApiConfig } from '@/shared/api/ApiConfig';
import AppFormFixedButton from '@/admin/components/form/AppFormFixedButton';

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
        onSuccess: () => {
            addNotification('Udało się zapisać dane!', ALERT_TYPES.SUCCESS);
        },
    };

    return (
        <>
            <h1 className="text-2xl font-bold mb-6">Secruity</h1>
            <AppForm
                apiConfig={createApiConfig(`admin/profile/${user.id}/change-password`, HTTP_METHODS.PUT)}
                handleSubmit={handleSubmit}
                setError={setError}
                apiRequestCallbacks={apiRequestCallbacks}
            >
                <div className="flex flex-col w-full gap-[40px]">
                    <AppInputPassword
                        id="password"
                        label="Hasło"
                        hasError={fieldErrors.hasOwnProperty('password')}
                        errorMessage={fieldErrors?.password?.message}
                        {...register('password', {
                            ...validationRules.required(),
                            ...validationRules.password(),
                        })}
                    />
                    <AppInputPassword
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
                </div>

                <AppFormFixedButton />
            </AppForm>
        </>
    );
};

export default ProfileSecurityForm;
