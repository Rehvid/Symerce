import React, { FC } from 'react';
import PaymentMethodInformationSection from '@admin/modules/paymentMethod/components/PaymentMethodInformationSection';
import PaymentMethodConfigurationSection from '@admin/modules/paymentMethod/components/PaymentMethodConfigurationSection';
import { Control, FieldErrors, UseFormRegister, UseFormSetValue, useWatch } from 'react-hook-form';
import { PaymentMethodFormData } from '@admin/modules/paymentMethod/interfaces/PaymentMethodFormData';

interface PaymentMethodFormBodyProps {
    register: UseFormRegister<PaymentMethodFormData>;
    fieldErrors: FieldErrors<PaymentMethodFormData>;
    control: Control<PaymentMethodFormData>;
    formData: PaymentMethodFormData;
    setValue: UseFormSetValue<PaymentMethodFormData>
}

const PaymentMethodFormBody: FC<PaymentMethodFormBodyProps> = ({register, fieldErrors, control, formData, setValue}) => {
    const isRequireWebhook = useWatch({
        control,
        name: 'isRequireWebhook',
    });

    return (
        <>
            <PaymentMethodInformationSection
                register={register}
                fieldErrors={fieldErrors}
                formData={formData}
                setValue={setValue}
            />
            {isRequireWebhook && (
                <PaymentMethodConfigurationSection
                    register={register}
                    fieldErrors={fieldErrors}
                    control={control}
                />
            )}
        </>
    )
}


export default PaymentMethodFormBody;
