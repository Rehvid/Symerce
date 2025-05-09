import { useForm } from 'react-hook-form';
import AppButton from '@/admin/components/common/AppButton';
import AppLink from '@/admin/components/common/AppLink';
import { validationRules } from '@/admin/utils/validationRules';
import UserIcon from '@/images/icons/user.svg';
import { useNavigate } from 'react-router-dom';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import ApiForm from '@/admin/components/form/ApiForm';
import InputEmail from '@/admin/components/form/controls/InputEmail';
import Input from '@/admin/components/form/controls/Input';
import InputPassword from '@/admin/components/form/controls/InputPassword';

const RegisterForm = () => {
    const {
        register,
        handleSubmit,
        setError,
        formState: { errors: fieldErrors },
    } = useForm({
        mode: 'onBlur',
    });

    const navigate = useNavigate();
    const apiRequestCallbacks = {
        onSuccess: () => {
            navigate('/admin/public/login');
        },
    };

    return (
        <ApiForm
            handleSubmit={handleSubmit}
            setError={setError}
            apiConfig={createApiConfig('auth/register', HTTP_METHODS.POST)}
            apiRequestCallbacks={apiRequestCallbacks}
        >
            <div className="flex flex-col w-full gap-[40px]">
                <InputEmail
                    hasError={!!fieldErrors?.email}
                    errorMessage={fieldErrors?.email?.message}
                    {...register('email', {
                        ...validationRules.required(),
                        ...validationRules.minLength(3),
                    })}
                />
                <Input
                    {...register('firstname', {
                        ...validationRules.required(),
                        ...validationRules.minLength(3),
                    })}
                    type="text"
                    id="firstname"
                    label="Imie"
                    hasError={!!fieldErrors?.firstname}
                    errorMessage={fieldErrors?.firstname?.message}
                    isRequired
                    icon={<UserIcon className="text-gray-500 w-[24px] h-[24px]" />}
                />
                <Input
                    {...register('surname', {
                        ...validationRules.required(),
                        ...validationRules.minLength(2),
                    })}
                    type="text"
                    id="surname"
                    label="Nazwisko"
                    hasError={!!fieldErrors?.surname}
                    errorMessage={fieldErrors?.surname?.message}
                    isRequired
                    icon={<UserIcon className="text-gray-500 w-[24px] h-[24px]" />}
                />
                <InputPassword
                    id="password"
                    label="Hasło"
                    hasError={!!fieldErrors?.password}
                    errorMessage={fieldErrors?.password?.message}
                    {...register('password', {
                        ...validationRules.required(),
                        ...validationRules.password(),
                    })}
                />
                <InputPassword
                    id="password-confirmation"
                    label="Powtórz hasło"
                    hasError={!!fieldErrors?.passwordConfirmation}
                    errorMessage={fieldErrors?.passwordConfirmation?.message}
                    {...register('passwordConfirmation', {
                        ...validationRules.required(),
                        validate(passwordConfirmation, { password }) {
                            return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                        },
                    })}
                />
                <div>
                    <AppButton variant="primary" type="submit" additionalClasses="px-4 py-2 w-full">
                        Zarejestruj sie
                    </AppButton>
                </div>
                <AppLink to="/admin/public/login" additionalClasses="w-full text-center">
                    Masz konto? Zaloguj się!
                </AppLink>
            </div>
        </ApiForm>
    );
};

export default RegisterForm;
