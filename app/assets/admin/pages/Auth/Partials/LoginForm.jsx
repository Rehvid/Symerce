import AppInput from '../../../../shared/components/Form/AppInput';
import RouterLink from '../../../../shared/components/RouterLink';
import React from 'react';
import { useForm } from 'react-hook-form';

const LoginForm = ({ onSubmit }) => {
    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm();

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
            <div>
                <button
                    className="cursor-pointer w-full bg-indigo-500 text-white text-sm font-bold py-3 px-4 rounded-md hover:bg-indigo-600 transition duration-300"
                    type="submit"
                >
                    Zaloguj się
                </button>
            </div>
            <RouterLink navigateTo="/admin/register" label="Nie masz konta? Zarejestruj się" />
        </form>
    );
};

export default LoginForm;
