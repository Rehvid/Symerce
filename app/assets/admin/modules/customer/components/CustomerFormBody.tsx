import CustomerDeliveryAddress from '@admin/modules/customer/components/section/CustomerDeliveryAddress';
import CustomerInvoiceAddress from '@admin/modules/customer/components/section/CustomerInvoiceAddress';
import CustomerInformation from '@admin/modules/customer/components/section/CustomerInformation';
import { CustomerFormData } from '@admin/modules/customer/interfaces/CustomerFormData';
import { FC } from 'react';
import { Control, FieldErrors, UseFormRegister, useWatch } from 'react-hook-form';
import { CustomerFormContext } from '@admin/modules/customer/interfaces/CustomerFormContext';

interface CustomerFormBodyProps {
    register: UseFormRegister<CustomerFormData>;
    isEditMode: boolean;
    fieldErrors: FieldErrors<CustomerFormData>;
    control: Control<CustomerFormData>;
    formContext: CustomerFormContext;
}

const CustomerFormBody: FC<CustomerFormBodyProps> = ({ register, fieldErrors, isEditMode, control, formContext }) => {
    const isDelivery = useWatch({
        control,
        name: 'isDelivery',
    });

    const isInvoice = useWatch({
        control,
        name: 'isInvoice',
    });

    return (
        <>
            <CustomerInformation register={register} fieldErrors={fieldErrors} isEditMode={isEditMode} />
            {isDelivery && (
                <CustomerDeliveryAddress
                    register={register}
                    fieldErrors={fieldErrors}
                    control={control}
                    formContext={formContext}
                />
            )}
            {isInvoice && (
                <CustomerInvoiceAddress
                    register={register}
                    fieldErrors={fieldErrors}
                    control={control}
                    formContext={formContext}
                />
            )}
        </>
    );
};

export default CustomerFormBody;
