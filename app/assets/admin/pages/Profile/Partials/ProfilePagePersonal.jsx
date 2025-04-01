import React, {useState} from "react";
import {useForm} from "react-hook-form";
import {useValidationErrors} from "@/admin/hooks/useValidationErrors";
import AppInput from "@/shared/components/Form/AppInput";
import {validationRules} from "@/admin/utilities/validationRules";
import MailIcon from "@/images/shared/mail.svg";
import UserIcon from "@/images/shared/user.svg";
import AppButton from "@/admin/components/Common/AppButton";
import {useAuth} from "@/admin/hooks/useAuth";
import {createApiConfig} from "@/shared/api/ApiConfig";
import {useApi} from "@/admin/hooks/useApi";

const ProfilePagePersonal = () => {
    const { user, setUser } = useAuth();
    const { executeRequest } = useApi();
    const [validationErrors, setValidationErrors] = useState({});
    const {
        register,
        handleSubmit,
        setError,
        formState: {
            errors,
        },
    } = useForm({
        mode: "onBlur",
        defaultValues: {
            email: user.email,
            firstname: user.firstname,
            surname: user.surname,
            id: user.id
        }
    });
    useValidationErrors(validationErrors, setError);

    const onSubmit = async (values) => {
        const config = createApiConfig(`profile/${user.id}/update-personal`, 'PUT', true);
        const { data, errors } = await executeRequest(config, values);
        if (errors.length === 0) {
            setUser(user => ({...user, ...data}));
        } else {
            setValidationErrors(errors?.details || {});
        }
    }


    return (
        <>
            <h1 className="text-2xl font-bold mb-6">Personal Information</h1>

            <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col gap-[40px]">
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
                    icon={<UserIcon className="text-gray-500" />}
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
                    icon={<UserIcon className="text-gray-500" />}
                />
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
                    icon={<MailIcon className="text-gray-500" />}
                />

                <div className="flex justify-end">
                    <AppButton variant="primary" type="submit" additionalClasses="px-5 py-2.5 ">
                        Zapisz
                    </AppButton>
                </div>

            </form>
        </>
    )
}

export default ProfilePagePersonal;
