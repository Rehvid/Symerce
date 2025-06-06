import React, { FC, useState } from 'react';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import { User } from '@admin/common/context/UserContext';
import login from '@admin/modules/authentication/pages/Login';
import { AlertProps } from '@admin/common/components/Alert';
import { AlertType } from '@admin/common/enums/alertType';
import { useForm } from 'react-hook-form';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Button, { ButtonVariant } from '@admin/common/components/Button';
import Link from '@admin/common/components/Link';

interface RemindPasswordFormData {
    email: string
}

const RemindPasswordForm: FC = () => {
    const {
        register,
        handleSubmit,
        setError,
        formState: { errors: fieldErrors },
    } = useForm<RemindPasswordFormData>({
        mode: 'onBlur',
    });

    const [alert, setAlert] = useState<AlertProps | null>(null);
    const apiRequestCallbacks = {
        onSuccess: (data: User) => {
            login(data.user);
            setAlert({
                variant: AlertType.INFO,
                message: 'Link przypominajacy hasło został wysłany na podany adres e-mail',
            });
        },
    };

    return (
        <FormWrapper
            method={HttpMethod.POST}
            endpoint="admin/auth/remind-password"
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={apiRequestCallbacks}
            additionalAlerts={alert}
        >
            <section className="flex flex-col gap-[2rem] px-2 py-5">
                <div className="flex flex-col gap-1">
                    <InputLabel label="Email" htmlFor="email" hasError={!!fieldErrors?.email} />
                    <InputField
                        type="text"
                        id="email"
                        hasError={!!fieldErrors?.email}
                        errorMessage={fieldErrors?.email?.message}
                        icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                        {...register('email', {
                            ...validationRules.required(),
                            ...validationRules.minLength(2),
                        })}
                    />
                </div>

                <div className="flex flex-col gap-5">
                    <Button variant={ButtonVariant.Primary} type="submit">
                        Wyślij
                    </Button>
                    <Link to="/admin/public/login" additionalClasses="w-full text-center">
                        Zaloguj się
                    </Link>
                </div>
            </section>
        </FormWrapper>
    );
};

export default RemindPasswordForm;
