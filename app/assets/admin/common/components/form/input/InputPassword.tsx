import React, { useState, ForwardedRef } from 'react';
import EyeIcon from '@/images/icons/eye.svg';
import InputField from '@admin/common/components/form/input/InputField';

type InputPasswordProps = {
    id: string;
    label?: string;
    hasError?: boolean;
    errorMessage?: string;
    isRequired?: boolean;
    [key: string]: any;
};

const InputPassword = React.forwardRef<HTMLInputElement, InputPasswordProps>(
    ({ id, hasError = false, errorMessage, label, ...register }, ref: ForwardedRef<HTMLInputElement>) => {
        const [showPassword, setShowPassword] = useState(false);

        const togglePassword = () => {
            setShowPassword((prevShowPassword) => !prevShowPassword);
        };

        return (
            <InputField
                type={showPassword ? 'text' : 'password'}
                id={id}
                hasError={hasError}
                errorMessage={errorMessage}
                icon={
                    <EyeIcon
                        onClick={togglePassword}
                        className={`w-[24px] h-[24px] cursor-pointer transition-all ${
                            showPassword ? 'text-primary' : 'text-gray-500 hover:text-primary-hover'
                        }`}
                    />
                }
                ref={ref}
                {...register}
            />
        );
    },
);

export default InputPassword;
