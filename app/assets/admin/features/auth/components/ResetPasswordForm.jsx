import React from 'react';
import { useForm } from 'react-hook-form';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { validationRules } from '@/admin/utils/validationRules';
import AppButton from '@/admin/components/common/AppButton';
import { useNavigate } from 'react-router-dom';
import AppInputPassword from '@/admin/components/form/AppInputPassword';
import AppForm from '@/admin/components/form/AppForm';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';

const ResetPasswordForm = ({ token }) => {
    const {
        register,
        handleSubmit,
        formState: { errors: fieldErrors },
        setError,
    } = useForm({
        mode: 'onBlur',
    });

    const navigate = useNavigate();
    const apiRequestCallbacks = {
        onSuccess: () => {
            navigate('/admin/public/login');
        },
    };

    return (
        <AppForm
            handleSubmit={handleSubmit}
            apiConfig={createApiConfig(`auth/${token}/reset-password`, HTTP_METHODS.PUT)}
            setError={setError}
            apiRequestCallbacks={apiRequestCallbacks}
        >
            <div className="flex flex-col gap-[40px] w-full">
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
                <div className="flex justify-end">
                    <AppButton variant="primary" type="submit" additionalClasses="px-5 py-2.5 ">
                        Zapisz
                    </AppButton>
                </div>
            </div>
        </AppForm>
    );
};

export default ResetPasswordForm;
