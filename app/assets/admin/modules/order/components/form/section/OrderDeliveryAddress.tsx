import FormSection from '@admin/common/components/form/FormSection';
import React from 'react';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import Switch from '@admin/common/components/form/input/Switch';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import { OrderFormContext } from '@admin/modules/order/interfaces/OrderFormContext';
import AddressDeliveryFields from '@admin/common/components/form/fields/formGroup/AddressDeliveryFields';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';

interface OrderDeliveryAddressProps {
    register: UseFormRegister<OrderFormData>;
    fieldErrors: FieldErrors<OrderFormData>;
    control: Control<OrderFormData>;
    formContext: OrderFormContext;
}

const OrderDeliveryAddress: React.FC<OrderDeliveryAddressProps> = ({ register, fieldErrors, control, formContext }) => (
    <FormSection title="Adres dostawy">
        <AddressDeliveryFields
            register={register}
            control={control}
            fieldErrors={fieldErrors}
            availableCountries={formContext?.availableCountries}
            useDeliveryInstructions={true}
        />

        <FormSwitchField register={register} fieldErrors={fieldErrors} name="isInvoice" label="Dodać fakture?" />
    </FormSection>
);

export default OrderDeliveryAddress;
