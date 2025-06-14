import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import Switch from '@admin/common/components/form/input/Switch';
import React, { FC } from 'react';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import { CustomerFormData } from '@admin/modules/customer/interfaces/CustomerFormData';
import { CustomerFormContext } from '@admin/modules/customer/interfaces/CustomerFormContext';
import AddressDelivery from '@admin/common/components/form/AddressDelivery';

interface CustomerDeliveryAddressProps {
    register: UseFormRegister<CustomerFormData>;
    fieldErrors: FieldErrors<CustomerFormData>;
    control: Control<CustomerFormData>;
    formContext: CustomerFormContext;
}

const CustomerDeliveryAddress: FC<CustomerDeliveryAddressProps> = ({ register, fieldErrors, control, formContext }) => {
    return (
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
};

export default CustomerDeliveryAddress;
