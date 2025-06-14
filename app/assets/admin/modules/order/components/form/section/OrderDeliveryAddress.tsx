import FormSection from '@admin/common/components/form/FormSection';
import React from 'react';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import Switch from '@admin/common/components/form/input/Switch';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import { OrderFormContext } from '@admin/modules/order/interfaces/OrderFormContext';
import AddressDelivery from '@admin/common/components/form/AddressDelivery';

interface OrderDeliveryAddressProps {
    register: UseFormRegister<OrderFormData>;
    fieldErrors: FieldErrors<OrderFormData>;
    control: Control<OrderFormData>;
    formContext: OrderFormContext;
}

const OrderDeliveryAddress: React.FC<OrderDeliveryAddressProps> = ({ register, fieldErrors, control, formContext }) => (
    <FormSection title="Adres dostawy">
        <AddressDelivery
            register={register}
            control={control}
            fieldErrors={fieldErrors}
            availableCountries={formContext?.availableCountries}
            useDeliveryInstructions={true}
        />

        <FormGroup label={<InputLabel label="Dodać fakture?" />}>
            <Switch {...register('isInvoice')} />
        </FormGroup>
    </FormSection>
);

export default OrderDeliveryAddress;
