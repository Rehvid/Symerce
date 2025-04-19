import EyeIcon from '@/images/icons/eye.svg';
import React, { useState } from 'react';
import Input from '@/admin/components/form/controls/Input';

const InputPassword = React.forwardRef(({ id, hasError, errorMessage, label, ...register }, ref) => {
    const [showPassword, setShowPassword] = useState(false);
    const togglePassword = () => {
        setShowPassword((prevShowPassword) => !prevShowPassword);
    };

    return (
        <Input
            type={`${showPassword ? 'text' : 'password'}`}
            id={id}
            label={label}
            hasError={hasError}
            errorMessage={errorMessage}
            icon={
                <EyeIcon
                    onClick={togglePassword}
                    className={`cursor-pointer transition-all ${showPassword ? 'text-primary ' : 'text-gray-500 hover:text-primary-hover'}`}
                />
            }
            isRequired
            ref={ref}
            {...register}
        />
    );
});

export default InputPassword;
