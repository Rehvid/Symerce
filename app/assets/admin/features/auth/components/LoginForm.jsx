import React from 'react';
import { useForm } from 'react-hook-form';
import AppButton from '@/admin/components/common/AppButton';
import AppLink from '@/admin/components/common/AppLink';
import { validationRules } from '@/admin/utils/validationRules';
import AppInputPassword from '@/admin/components/form/AppInputPassword';
import AppInputEmail from '@/admin/components/form/AppInputEmail';
import { useNavigate } from 'react-router-dom';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { useAuth } from '@/admin/hooks/useAuth';
import AppForm from '@/admin/components/form/AppForm';

const LoginForm = ({ setAlert }) => {
    const {
        register,
        handleSubmit,
        formState: { errors: fieldErrors },
        setError,
    } = useForm({
        mode: 'onBlur',
    });
    const navigate = useNavigate();
    const { login } = useAuth();

    const apiRequestCallbacks = {
        onSuccess: (data) => {
            login(data.user);
            navigate('/admin/dashboard', { replace: true });
        },
    };

    return (
        <AppForm
            handleSubmit={handleSubmit}
            apiConfig={createApiConfig('login', HTTP_METHODS.POST)}
            apiRequestCallbacks={apiRequestCallbacks}
            setError={setError}
        >
            <div className="flex flex-col w-full gap-[40px]">
                <AppInputEmail
                    hasError={fieldErrors.hasOwnProperty('email')}
                    errorMessage={fieldErrors?.email?.message}
                    {...register('email', {
                        ...validationRules.required(),
                        ...validationRules.minLength(3),
                    })}
                />
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

                <div>
                    <AppButton variant="primary" type="submit" additionalClasses="px-4 py-2 w-full">
                        Zaloguj się
                    </AppButton>
                </div>
                <div className="flex flex-col gap-4">
                    <AppLink to="/admin/public/register" additionalClasses="w-full text-center">
                        Nie masz konta? Zarejestruj się
                    </AppLink>
                    <AppLink to="/admin/public/forgot-password" additionalClasses="w-full text-center">
                        Zapomniałeś hasła?
                    </AppLink>
                </div>
            </div>
        </AppForm>
    );
};

export default LoginForm;
