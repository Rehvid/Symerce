import { useState } from 'react';
import { useForm } from 'react-hook-form';
import AppButton from '@/admin/components/common/AppButton';
import { validationRules } from '@/admin/utils/validationRules';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import ApiForm from '@/admin/components/form/ApiForm';
import InputEmail from '@/admin/components/form/controls/InputEmail';

const ForgetPasswordForm = () => {
    const {
        register,
        handleSubmit,
        formState: { errors: fieldErrors },
        setError,
    } = useForm({
        mode: 'onBlur',
    });
    const [alert, setAlert] = useState({});

    const apiRequestCallbacks = {
        onSuccess: () => {
            setAlert({
                variant: ALERT_TYPES.INFO,
                message: 'Link przypominajacy hasło został wysłany na podany adres e-mail',
            });
        },
    };

    return (
        <ApiForm
            handleSubmit={handleSubmit}
            setError={setError}
            apiConfig={createApiConfig('auth/forgot-password', HTTP_METHODS.POST)}
            apiRequestCallbacks={apiRequestCallbacks}
            additionalAlerts={alert}
        >
            <div className="flex flex-col w-full gap-[40px]">
                <InputEmail
                    hasError={!!fieldErrors?.email}
                    errorMessage={fieldErrors?.email?.message}
                    {...register('email', {
                        ...validationRules.required(),
                        ...validationRules.minLength(3),
                    })}
                />

                <div>
                    <AppButton variant="primary" type="submit" additionalClasses="px-4 py-2 w-full">
                        Zresetuj hasło
                    </AppButton>
                </div>
            </div>
        </ApiForm>
    );
};

export default ForgetPasswordForm;
