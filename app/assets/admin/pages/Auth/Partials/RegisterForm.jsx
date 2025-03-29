import { useForm } from 'react-hook-form';
import AppInput from '../../../../shared/components/Form/AppInput';
import React, {useState} from 'react';
import AppButton from "@/admin/components/Common/AppButton";
import AppLink from "@/admin/components/Common/AppLink";
import {useValidationErrors} from "@/admin/hooks/useValidationErrors";
import {validationRules} from "@/admin/utilities/validationRules";
import EyeIcon from "@/images/shared/eye.svg";
import UserIcon from "@/images/shared/user.svg";
import MailIcon from "@/images/shared/mail.svg";

const RegisterForm = ({ onSubmit, validationErrors }) => {
    const {
        register,
        handleSubmit,
        setError,
        formState: { errors },
    } = useForm({
        mode: "onBlur",
    });
    useValidationErrors(validationErrors, setError);
    const [showPassword, setShowPassword] = useState(false);
    const [showPasswordConfirmation, setShowPasswordConfirmation] = useState(false);
    const togglePassword = () => {
        setShowPassword(showPassword => !showPassword);
    }
    const togglePasswordConfirmation = () => {
        setShowPasswordConfirmation(showPasswordConfirmation => !showPasswordConfirmation);
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
                isRequired
                icon={<MailIcon className="text-gray-500" />}
            />
            <AppInput
                {...register('firstname', {
                    ...validationRules.required(),
                    ...validationRules.minLength(3),
                })}
                type="text"
                id="firstname"
                label="Imie"
                hasError={errors.hasOwnProperty('firstname')}
                errorMessage={errors?.firstname?.message}
                isRequired
                icon={<UserIcon className="text-gray-500" />}
            />
            <AppInput
                {...register('surname', {
                    ...validationRules.required(),
                    ...validationRules.minLength(2),
                })}
                type="text"
                id="surname"
                label="Nazwisko"
                hasError={errors.hasOwnProperty('surname')}
                errorMessage={errors?.surname?.message}
                isRequired
                icon={<UserIcon className="text-gray-500" />}
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
                isRequired
                icon={<EyeIcon onClick={togglePassword} className="text-gray-500 cursor-pointer"/>}
            />
            <AppInput
                {...register('passwordConfirmation', {
                    ...validationRules.required(),
                    validate: function (passwordConfirmation, { password }) {
                        return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                    },
                })}
                type={`${showPasswordConfirmation ? 'text' : 'password'}`}
                id="password-confirmation"
                label="Powtórz hasło"
                hasError={errors.hasOwnProperty('passwordConfirmation')}
                errorMessage={errors?.passwordConfirmation?.message}
                isRequired
                icon={<EyeIcon onClick={togglePasswordConfirmation} className="text-gray-500 cursor-pointer"/>}
            />
            <div>
                <AppButton variant="primary" type="submit" additionalClasses="px-4 py-2 w-full">
                    Zarejestruj sie
                </AppButton>
            </div>
            <AppLink to="/admin/login" additionalClasses="w-full text-center">Masz konto? Zaloguj się!</AppLink>
        </form>
    );
};

export default RegisterForm;
