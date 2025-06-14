import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import { OrderFormContext } from '@admin/modules/order/interfaces/OrderFormContext';
import AddressInvoice from '@admin/common/components/form/AddressInvoice';

interface OrderInvoiceAddressProps {
    register: UseFormRegister<OrderFormData>;
    fieldErrors: FieldErrors<OrderFormData>;
    control: Control<OrderFormData>;
    formContext: OrderFormContext;
}

const OrderInvoiceAddress: React.FC<OrderInvoiceAddressProps> = ({ register, fieldErrors, control, formContext }) => (
    <FormSection title="Faktura">
      <AddressInvoice
        register={register}
        fieldErrors={fieldErrors}
        control={control}
        availableCountries={formContext?.availableCountries}
      />
    </FormSection>
);

export default OrderInvoiceAddress;
