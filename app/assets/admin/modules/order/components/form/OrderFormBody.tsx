import React from 'react';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import OrderContactDetails from '@admin/modules/order/components/form/section/OrderContactDetails';
import OrderDeliveryAddress from '@admin/modules/order/components/form/section/OrderDeliveryAddress';
import OrderInvoiceAddress from '@admin/modules/order/components/form/section/OrderInvoiceAddress';
import OrderInformation from '@admin/modules/order/components/form/section/OrderInformation';
import OrderShippingAndPayment from '@admin/modules/order/components/form/section/OrderShippingAndPayment';
import OrderProduct from '@admin/modules/order/components/form/section/OrderProduct';
import { Control, FieldErrors, UseFormRegister, useWatch } from 'react-hook-form';
import { OrderFormContext } from '@admin/modules/order/interfaces/OrderFormContext';

interface OrderFormBodyProps {
    register: UseFormRegister<OrderFormData>;
    control: Control<OrderFormData>;
    fieldErrors: FieldErrors<OrderFormData>;
    formData?: OrderFormData;
    formContext: OrderFormContext;
    isEditMode: boolean;
}

const OrderFormBody: React.FC<OrderFormBodyProps> = ({
    register,
    fieldErrors,
    formData,
    formContext,
    control,
    isEditMode,
}) => {
    const isInvoice = useWatch({ control, name: 'isInvoice' });

    return (
        <>
            <OrderInformation
                formData={formData}
                fieldErrors={fieldErrors}
                control={control}
                isEditMode={isEditMode}
                formContext={formContext}
            />
            <OrderContactDetails register={register} fieldErrors={fieldErrors} />
            <OrderDeliveryAddress
                register={register}
                fieldErrors={fieldErrors}
                formContext={formContext}
                control={control}
            />
            {isInvoice && (
                <OrderInvoiceAddress
                    register={register}
                    fieldErrors={fieldErrors}
                    formContext={formContext}
                    control={control}
                />
            )}
            <OrderShippingAndPayment control={control} formContext={formContext} />
            <OrderProduct register={register} fieldErrors={fieldErrors} control={control} formContext={formContext} />
        </>
    );
};

export default OrderFormBody;
