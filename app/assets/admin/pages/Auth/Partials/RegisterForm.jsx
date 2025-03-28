import { useForm } from 'react-hook-form';
import AppInput from '../../../../shared/components/Form/AppInput';
import React from 'react';
import AppButton from "@/admin/components/Common/AppButton";
import AppLink from "@/admin/components/Common/AppLink";
import {useValidationErrors} from "@/admin/hooks/useValidationErrors";
import {validationRules} from "@/admin/utilities/validationRules";

const RegisterForm = ({ onSubmit, validationErrors }) => {
    const {
        register,
        handleSubmit,
        setError,
        formState: { errors },
    } = useForm({
        mode: "onChange",
    });
     useValidationErrors(validationErrors, setError);

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
            />
            <AppInput
                {...register('password', {
                    ...validationRules.required(),
                    ...validationRules.password(),
                })}
                type="password"
                id="password"
                label="Hasło"
                hasError={errors.hasOwnProperty('password')}
                errorMessage={errors?.password?.message}
                isRequired
            />
            <AppInput
                {...register('passwordConfirmation', {
                    ...validationRules.required(),
                    validate: function (passwordConfirmation, { password }) {
                        return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                    },
                })}
                type="password"
                id="password-confirmation"
                label="Powtórz hasło"
                hasError={errors.hasOwnProperty('passwordConfirmation')}
                errorMessage={errors?.passwordConfirmation?.message}
                isRequired
            />
            <div>
                <AppButton variant="primary" type="submit" additionalClasses="px-4 py-2 w-full">
                    Zarejestruj sie
                </AppButton>
            </div>
            <AppLink to="/admin/register" additionalClasses="w-full text-center">Masz konto? Zaloguj się!</AppLink>
        </form>
    );
};

export default RegisterForm;
