import React, { FC, useEffect, useState } from 'react';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import { useForm } from 'react-hook-form';
import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import login from '@admin/modules/authentication/pages/Login';
import { useNavigate } from 'react-router-dom';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputPassword from '@admin/common/components/form/input/InputPassword';
import Button, { ButtonVariant } from '@admin/common/components/Button';
import Link from '@admin/common/components/Link';
import { User, useUser } from '@admin/common/context/UserContext';
import { useAuth } from '@admin/common/context/AuthroizationContext';

interface LoginFormData extends FormDataInterface {
    email: string;
    password: string;
}

const LoginForm: FC = () => {
    const {
        register,
        handleSubmit,
        setError,
        formState: { errors: fieldErrors },
    } = useForm<LoginFormData>({
        mode: 'onBlur',
    });

    const [shouldNavigate, setShouldNavigate] = useState<boolean>(false);
    const { login } = useAuth();
    const { user } = useUser();
    const navigate = useNavigate();

    useEffect(() => {
        if (user && shouldNavigate) {
            navigate('/admin/dashboard', { replace: true });
        }
    }, [user, shouldNavigate]);

    const apiRequestCallbacks = {
        onSuccess: (data: User) => {
            login(data.data.user);
            setShouldNavigate(true);
        },
    };

    return (
        <FormWrapper
            method={HttpMethod.POST}
            endpoint="login"
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={apiRequestCallbacks}
        >
            <section className="flex flex-col gap-[2rem] px-2 py-5 ">
                <div className="flex flex-col gap-1">
                    <InputLabel label="Email" htmlFor="email" hasError={!!fieldErrors?.email} />
                    <InputField
                        type="text"
                        id="email"
                        hasError={!!fieldErrors?.email}
                        errorMessage={fieldErrors?.email?.message}
                        icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                        {...register('email', {
                            ...validationRules.required(),
                            ...validationRules.minLength(2),
                        })}
                    />
                </div>

                <div className="flex flex-col gap-1">
                    <InputLabel label="Hasło" htmlFor="password" hasError={!!fieldErrors?.password} />
                    <InputPassword
                        id="password"
                        hasError={!!fieldErrors?.password}
                        errorMessage={fieldErrors?.password?.message}
                        {...register('password', {
                            ...validationRules.password(),
                        })}
                    />
                </div>

                <div className="flex flex-col gap-5">
                    <Button variant={ButtonVariant.Primary} type="submit">
                        Zaloguj się
                    </Button>
                    <Link to="/admin/public/remind-password" additionalClasses="w-full text-center">
                        Zapomniałeś hasła?
                    </Link>
                </div>
            </section>
        </FormWrapper>
    );
};

export default LoginForm;
