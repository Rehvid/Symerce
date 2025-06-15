import FormSection from '@admin/common/components/form/FormSection';
import React, { FC } from 'react';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import { CustomerFormData } from '@admin/modules/customer/interfaces/CustomerFormData';
import { CustomerFormContext } from '@admin/modules/customer/interfaces/CustomerFormContext';
import AddressInvoiceFields from '@admin/common/components/form/fields/formGroup/AddressInvoiceFields';

interface CustomerInvoiceAddressProps {
    register: UseFormRegister<CustomerFormData>;
    fieldErrors: FieldErrors<CustomerFormData>;
    control: Control<CustomerFormData>;
    formContext: CustomerFormContext;
}

const CustomerInvoiceAddress: FC<CustomerInvoiceAddressProps> = ({ fieldErrors, register, control, formContext }) => {
    return (
        <FormSection title="Faktura">
           <AddressInvoiceFields
               register={register}
               control={control}
               fieldErrors={fieldErrors}
               availableCountries={formContext?.availableCountries}
           />
        </FormSection>
    );
};

export default CustomerInvoiceAddress;
