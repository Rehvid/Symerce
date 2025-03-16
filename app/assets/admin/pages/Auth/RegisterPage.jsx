import React from "react";
import { useForm } from "react-hook-form"
import {useNavigate} from "react-router-dom";
import RestApiClient from "../../../shared/api/RestApiClient";

import RouterLink from "../../../shared/components/RouterLink";
import Input from "../../../shared/components/Input";

function RegisterPage () {
    let navigate = useNavigate();
    const {
        register,
        handleSubmit,
        setError,
        formState: {errors}
    } = useForm();
    const registerConfig = RestApiClient().createConfig("auth/register", "POST");

    const onSubmit = async (values) => {
        try {
            const response = await RestApiClient().sendRequest(registerConfig, values);
            const { success, errors } = response;

            if (success) {
                navigate('/admin/login');
            }

            handleErrorResponse(errors);
        } catch (e) {
            console.log("Unexpected error:", e);
        }
    }
        const handleErrorResponse = (errors) => {
            Object.keys(errors).forEach((key) => {
                setError(key, {type: "custom", message: errors[key]['message']});
            });
        }

        return (
            <div className="container mx-auto py-8">
                <h1 className="text-2xl font-bold mb-6 text-center">Zarejestruj się</h1>
                <form onSubmit={handleSubmit(onSubmit)} className="w-full max-w-sm mx-auto bg-white p-8 rounded-md shadow-md">
                    <Input
                        {...register('email', {
                            required: "Pole Email jest wymagane",
                            minLength: {
                                value: 3,
                                message: "Email musi mieć co najmniej 3 znaki",
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
                            required: "Pole hasło jest wymagane",
                            pattern: {
                                value: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/,
                                message: "Hasło musi mieć co najmniej 8 znaków, zawierać małą i wielką literę, cyfrę oraz znak specjalny.",
                            },
                        })}
                        type="password"
                        id="password"
                        label="Hasło"
                        hasError={errors.hasOwnProperty('password')}
                        errorMessage={errors?.password?.message}
                    />
                    <Input
                        {...register('passwordConfirmation', {
                            required: "Pole powtórz hasło jest wymagane",
                            validate: function (passwordConfirmation, {password}) {
                                return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                            }
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
                        >Zarejestruj się
                        </button>
                    </div>
                    <RouterLink
                        navigateTo="/admin/login"
                        label="Masz konto? Zaloguj się!"
                    />
                </form>
            </div>
        );
    }


export default RegisterPage;
