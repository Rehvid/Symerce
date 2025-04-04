import EyeIcon from '@/images/icons/eye.svg';

import React, { useState } from 'react';
import AppInput from '@/admin/components/form/AppInput';

const AppInputPassword = React.forwardRef(({ id, hasError, errorMessage, label, ...register }, ref) => {
    const [showPassword, setShowPassword] = useState(false);
    const togglePassword = () => {
        setShowPassword((showPassword) => !showPassword);
    };

    return (
        <AppInput
            type={`${showPassword ? 'text' : 'password'}`}
            id={id}
            label={label}
            hasError={hasError}
            errorMessage={errorMessage}
            icon={
                <EyeIcon
                    onClick={togglePassword}
                    className={`cursor-pointer transition-all ${showPassword ? 'text-primary-stronger ' : 'text-gray-500 hover:text-primary-stronger'}`}
                />
            }
            isRequired
            ref={ref}
            {...register}
        />
    );
});

export default AppInputPassword;
