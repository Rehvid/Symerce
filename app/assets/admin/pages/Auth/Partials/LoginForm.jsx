import AppInput from '../../../../shared/components/Form/AppInput';
import EyeIcon from '@/images/shared/eye.svg';
import React, {useState} from 'react';
import { useForm } from 'react-hook-form';
import AppButton from "@/admin/components/Common/AppButton";
import AppLink from "@/admin/components/Common/AppLink";
import {useValidationErrors} from "@/admin/hooks/useValidationErrors";
import {validationRules} from "@/admin/utilities/validationRules";
import MailIcon from "@/images/shared/mail.svg";

const LoginForm = ({ onSubmit }) => {
    const {
        register,
        handleSubmit,
        formState: { errors },
        setError
    } = useForm({
        mode: "onBlur",
    });

    const [validationErrors, setValidationErrors] = useState({});

    useValidationErrors(validationErrors, setError);
    const [showPassword, setShowPassword] = useState(false);
    const togglePassword = () => {
        setShowPassword(showPassword => !showPassword);
    }

    return (
        <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col gap-[40px]">
            <AppInput
                {...register('email', {
                    ...validationRules.required(),
                    ...validationRules.minLength(3),
                })}
                type="email"
                id="email"
                label="Adres e-mail"
                hasError={errors.hasOwnProperty('email')}
                errorMessage={errors?.email?.message}
                icon={<MailIcon className="text-gray-500" />}
                isRequired
            />
            <AppInput
                {...register('password', {
                    ...validationRules.required(),
                    ...validationRules.password(),
                })}
                type={`${showPassword ? 'text' : 'password'}`}
                id="password"
                label="Hasło"
                hasError={errors.hasOwnProperty('password')}
                errorMessage={errors?.password?.message}
                icon={<EyeIcon onClick={togglePassword} className="text-gray-500 cursor-pointer"/>}
                isRequired
            />

            <div>
                <AppButton variant="primary" type="submit" additionalClasses="px-4 py-2 w-full">
                    Zaloguj się
                </AppButton>
            </div>
            <AppLink to="/admin/register" additionalClasses="w-full text-center">Nie masz konta? Zarejestruj się</AppLink>
        </form>
    );
};

export default LoginForm;
