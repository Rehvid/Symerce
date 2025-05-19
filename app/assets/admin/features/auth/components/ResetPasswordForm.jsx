import { useForm } from 'react-hook-form';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { validationRules } from '@/admin/utils/validationRules';
import AppButton from '@/admin/components/common/AppButton';
import { useNavigate } from 'react-router-dom';
import ApiForm from '@/admin/components/form/ApiForm';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import InputPassword from '@/admin/components/form/controls/InputPassword';

const ResetPasswordForm = ({ token }) => {
    const {
        register,
        handleSubmit,
        formState: { errors: fieldErrors },
        setError,
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
            apiConfig={createApiConfig(`admin/auth/${token}/reset-password`, HTTP_METHODS.PUT)}
            setError={setError}
            apiRequestCallbacks={apiRequestCallbacks}
        >
            <div className="flex flex-col gap-[40px] w-full">
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
                <div className="flex justify-end">
                    <AppButton variant="primary" type="submit" additionalClasses="px-5 py-2.5 ">
                        Zapisz
                    </AppButton>
                </div>
            </div>
        </ApiForm>
    );
};

export default ResetPasswordForm;
