import MailIcon from '@/images/icons/mail.svg';
import React from 'react';
import Input from '@/admin/components/form/controls/Input';

const InputEmail = React.forwardRef(({ hasError, errorMessage, ...register }, ref) => {
    return (
        <Input
            type="email"
            id="email"
            label="Adres e-mail"
            hasError={hasError}
            errorMessage={errorMessage}
            icon={<MailIcon className="text-gray-500 w-[24px] h-[24px]" />}
            isRequired
            ref={ref}
            {...register}
        />
    );
});

export default InputEmail;
