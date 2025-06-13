import React, { FC } from 'react';
import { useForm } from 'react-hook-form';
import { useNavigate } from 'react-router-dom';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { validationRules } from '@admin/common/utils/validationRules';
import InputPassword from '@admin/common/components/form/input/InputPassword';
import Button, { ButtonVariant } from '@admin/common/components/Button';

interface ResetPasswordFormData {
    password: string;
    passwordConfirmation: string;
}

interface ResetPasswordFormProps {
    token: string;
}

const ResetPasswordForm: FC<ResetPasswordFormProps> = ({ token }) => {
    const {
        register,
        handleSubmit,
        setError,
        formState: { errors: fieldErrors },
    } = useForm<ResetPasswordFormData>({
        mode: 'onBlur',
    });

    const navigate = useNavigate();
    const apiRequestCallbacks = {
        onSuccess: () => {
            navigate('/admin/public/login');
        },
    };

    return (
        <FormWrapper
            method={HttpMethod.PUT}
            endpoint={`admin/auth/${token}/reset-password`}
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={apiRequestCallbacks}
        >
            <section className="flex flex-col gap-[2rem] px-2 py-5 ">
                <div className="flex flex-col gap-1">
                    <InputLabel label="Hasło" htmlFor="password" hasError={!!fieldErrors?.password} />
                    <InputPassword
                        id="password"
                        hasError={!!fieldErrors?.password}
                        errorMessage={fieldErrors?.password?.message}
                        {...register('password', {
                            ...validationRules.password(),
                        })}
                    />
                </div>

                <div className="flex flex-col gap-1">
                    <InputLabel
                        label="Powtórz hasło"
                        htmlFor="passwordConfirmation"
                        hasError={!!fieldErrors?.passwordConfirmation}
                    />
                    <InputPassword
                        id="password-confirmation"
                        hasError={!!fieldErrors?.passwordConfirmation}
                        errorMessage={fieldErrors?.passwordConfirmation?.message}
                        {...register('passwordConfirmation', {
                            validate(passwordConfirmation, { password }) {
                                return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                            },
                        })}
                    />
                </div>

                <div className="flex flex-col gap-5">
                    <Button variant={ButtonVariant.Primary} type="submit">
                        Zaloguj się
                    </Button>
                </div>
            </section>
        </FormWrapper>
    );
};

export default ResetPasswordForm;
