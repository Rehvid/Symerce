import AppInput from '../../../../shared/components/Form/AppInput';
import UserIcon from '@/images/shared/user.svg';
import EyeIcon from '@/images/shared/eye.svg';
import React, {useState} from 'react';
import { useForm } from 'react-hook-form';
import AppButton from "@/admin/components/Common/AppButton";
import AppLink from "@/admin/components/Common/AppLink";

const LoginForm = ({ onSubmit }) => {
    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm();
    const [showPassword, setShowPassword] = useState(false);
    const togglePassword = () => {
        setShowPassword(showPassword => !showPassword);
    }

    return (
        <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col gap-[40px]">
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
                icon={<UserIcon className="text-gray-500" />}
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
                type={`${showPassword ? 'text' : 'password'}`}
                id="password"
                label="Hasło"
                hasError={errors.hasOwnProperty('password')}
                errorMessage={errors?.password?.message}
                icon={<EyeIcon onClick={togglePassword} className="text-gray-500 cursor-pointer"/>}
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
