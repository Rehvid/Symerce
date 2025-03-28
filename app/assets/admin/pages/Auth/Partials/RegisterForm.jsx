import { useForm } from 'react-hook-form';
import AppInput from '../../../../shared/components/Form/AppInput';
import RouterLink from '../../../../shared/components/RouterLink';
import React, { useEffect } from 'react';

const RegisterForm = ({ onSubmit, validationErrors }) => {
    const {
        register,
        handleSubmit,
        setError,
        formState: { errors },
    } = useForm();

    useEffect(() => {
        if (validationErrors) {
            handleErrorResponse(validationErrors);
        }
    }, [validationErrors]);

    const handleErrorResponse = errors => {
        Object.keys(errors).forEach(key => {
            setError(key, { type: 'custom', message: errors[key]['message'] });
        });
    };

    return (
        <form onSubmit={handleSubmit(onSubmit)} className="w-full max-w-sm mx-auto bg-white p-8 rounded-md shadow-md">
            <AppInput
                {...register('email', {
                    required: 'Pole Email jest wymagane',
                    minLength: {
                        value: 3,
                        message: 'Email musi mieć co najmniej 3 znaki',
                    },
                })}
                type="email"
                id="email"
                label="Adres e-mail"
                hasError={errors.hasOwnProperty('email')}
                errorMessage={errors?.email?.message}
            />
            <AppInput
                {...register('firstname', {
                    required: 'Pole Imie jest wymagane',
                    minLength: {
                        value: 2,
                        message: 'Imię musi mieć co najmniej 2 znaki',
                    },
                })}
                type="text"
                id="firstname"
                label="Imie"
                hasError={errors.hasOwnProperty('firstname')}
                errorMessage={errors?.firstname?.message}
            />
            <AppInput
                {...register('surname', {
                    required: 'Pole Nazwisko jest wymagane',
                    minLength: {
                        value: 2,
                        message: 'Nazwisko musi mieć co najmniej 3 znaki',
                    },
                })}
                type="text"
                id="surname"
                label="Nazwisko"
                hasError={errors.hasOwnProperty('nazwisko')}
                errorMessage={errors?.surname?.message}
            />
            <AppInput
                {...register('password', {
                    required: 'Pole hasło jest wymagane',
                    pattern: {
                        value: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/,
                        message:
                            'Hasło musi mieć co najmniej 8 znaków, zawierać małą i wielką literę, cyfrę oraz znak specjalny.',
                    },
                })}
                type="password"
                id="password"
                label="Hasło"
                hasError={errors.hasOwnProperty('password')}
                errorMessage={errors?.password?.message}
            />
            <AppInput
                {...register('passwordConfirmation', {
                    required: 'Pole powtórz hasło jest wymagane',
                    validate: function (passwordConfirmation, { password }) {
                        return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                    },
                })}
                type="password"
                id="password-confirmation"
                label="Powtórz hasło"
                hasError={errors.hasOwnProperty('passwordConfirmation')}
                errorMessage={errors?.passwordConfirmation?.message}
            />
            <div>
                <button
                    className="cursor-pointer w-full bg-indigo-500 text-white text-sm font-bold py-3 px-4 rounded-md hover:bg-indigo-600 transition duration-300"
                    type="submit"
                >
                    Zarejestruj się
                </button>
            </div>
            <RouterLink navigateTo="/admin/login" label="Masz konto? Zaloguj się!" />
        </form>
    );
};

export default RegisterForm;
