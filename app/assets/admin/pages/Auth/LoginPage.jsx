import { useForm } from 'react-hook-form';
import React from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import RestApiClient from '../../../shared/api/RestApiClient';
import RouterLink from '../../../shared/components/RouterLink';
import Input from '../../../shared/components/Input';

function LoginPage() {
    let navigate = useNavigate();
    const { login } = useAuth();
    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm();
    const apiConfig = RestApiClient().createConfig('login_check', 'POST');

    const onSubmit = async values => {
        try {
            const request = await RestApiClient().sendRequest(apiConfig, values);
            const { token } = request;
            if (token) {
                login();
                navigate('/admin/dashboard');
            }
        } catch (e) {
            console.error('Unexpected error', e);
        }
    };

    return (
        <div className="container mx-auto py-8">
            <h1 className="text-2xl font-bold mb-6 text-center">Zaloguj się</h1>
            <form
                onSubmit={handleSubmit(onSubmit)}
                className="w-full max-w-sm mx-auto bg-white p-8 rounded-md shadow-md"
            >
                <Input
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
                <Input
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
        </div>
    );
}

export default LoginPage;
