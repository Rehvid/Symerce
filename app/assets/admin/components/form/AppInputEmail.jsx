import MailIcon from '@/images/icons/mail.svg';
import React from 'react';
import AppInput from '@/admin/components/form/AppInput';

const AppInputEmail = React.forwardRef(({ hasError, errorMessage, ...register }, ref) => {
    return (
        <AppInput
            type="email"
            id="email"
            label="Adres e-mail"
            hasError={hasError}
            errorMessage={errorMessage}
            icon={<MailIcon className="text-gray-500" />}
            isRequired
            ref={ref}
            {...register}
        />
    );
});

export default AppInputEmail;
