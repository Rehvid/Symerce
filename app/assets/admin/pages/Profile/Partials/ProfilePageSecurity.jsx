import AppInput from "@/shared/components/Form/AppInput";
import {validationRules} from "@/admin/utilities/validationRules";
import UserIcon from "@/images/shared/user.svg";
import MailIcon from "@/images/shared/mail.svg";
import AppButton from "@/admin/components/Common/AppButton";
import React, {useState} from "react";
import {useAuth} from "@/admin/hooks/useAuth";
import {useApi} from "@/admin/hooks/useApi";
import {useForm} from "react-hook-form";
import {useValidationErrors} from "@/admin/hooks/useValidationErrors";
import {createApiConfig} from "@/shared/api/ApiConfig";
import EyeIcon from "@/images/shared/eye.svg";

const ProfilePageSecurity = () => {
    const {user} = useAuth();
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
    });

    useValidationErrors(validationErrors, setError);
    const [showPassword, setShowPassword] = useState(false);
    const [showPasswordConfirmation, setShowPasswordConfirmation] = useState(false);
    const togglePassword = () => {
        setShowPassword(showPassword => !showPassword);
    }
    const togglePasswordConfirmation = () => {
        setShowPasswordConfirmation(showPasswordConfirmation => !showPasswordConfirmation);
    }

    const onSubmit = async (values) => {
        const config = createApiConfig(`profile/${user.id}/change-password`, 'PUT', true);
        const { errors } = await executeRequest(config, values);
        if (errors.length < 0) {
            setValidationErrors(errors?.details || {});
        }
    }


    return (
        <>
            <h1 className="text-2xl font-bold mb-6">Personal Information</h1>

            <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col gap-[40px]">
                <AppInput
                    {...register('password', {
                        ...validationRules.required(),
                        ...validationRules.password(),
                    })}
                    type={`${showPassword ? 'text' : 'password'}`}
                    id="password"
                    label="Hasło"
                    hasError={errors.hasOwnProperty('password')}
                    errorMessage={errors?.password?.message}
                    isRequired
                    icon={<EyeIcon onClick={togglePassword} className="text-gray-500 cursor-pointer"/>}
                />
                <AppInput
                    {...register('passwordConfirmation', {
                        ...validationRules.required(),
                        validate: function (passwordConfirmation, { password }) {
                            return passwordConfirmation === password || 'Hasła muszą być identyczne.';
                        },
                    })}
                    type={`${showPasswordConfirmation ? 'text' : 'password'}`}
                    id="password-confirmation"
                    label="Powtórz hasło"
                    hasError={errors.hasOwnProperty('passwordConfirmation')}
                    errorMessage={errors?.passwordConfirmation?.message}
                    isRequired
                    icon={<EyeIcon onClick={togglePasswordConfirmation} className="text-gray-500 cursor-pointer"/>}
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

export default ProfilePageSecurity;
