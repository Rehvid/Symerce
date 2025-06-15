import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React, { FC } from 'react';
import Switch from '@admin/common/components/form/input/Switch';
import { CustomerFormData } from '@admin/modules/customer/interfaces/CustomerFormData';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import PasswordFields from '@admin/common/components/form/fields/PasswordFields';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';
import ContactDetailsFields from '@admin/common/components/form/fields/formGroup/ContactDetailsFields';

interface CustomerInformationProps {
    register: UseFormRegister<CustomerFormData>;
    isEditMode: boolean;
    fieldErrors: FieldErrors<CustomerFormData>;
}

const CustomerInformation: FC<CustomerInformationProps> = ({ register, fieldErrors, isEditMode }) => (
    <FormSection title="Informacje">
        <ContactDetailsFields register={register} fieldErrors={fieldErrors} />
        <PasswordFields register={register} fieldErrors={fieldErrors} isEditMode={isEditMode} />
        <FormSwitchField register={register} name="isActive" label="Dostępny" />
        <FormSwitchField register={register} name="isDelivery" label="Dodać adres dostawy?" />
    </FormSection>
);

export default CustomerInformation;
