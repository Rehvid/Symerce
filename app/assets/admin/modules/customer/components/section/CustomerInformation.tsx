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
import PasswordSection from '@admin/common/components/form/PasswordSection';

interface CustomerInformationProps {
    register: UseFormRegister<CustomerFormData>;
    isEditMode: boolean;
    fieldErrors: FieldErrors<CustomerFormData>;
}

const CustomerInformation: FC<CustomerInformationProps> = ({ register, fieldErrors, isEditMode }) => (
    <FormSection title="Informacje">
        <FormGroup label={<InputLabel isRequired={true} label="Imie" htmlFor="firstname" />}>
            <InputField
                type="text"
                id="firstname"
                hasError={!!fieldErrors?.firstname}
                errorMessage={fieldErrors?.firstname?.message}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('firstname', {
                    ...validationRules.required(),
                    ...validationRules.minLength(2),
                })}
            />
        </FormGroup>
        <FormGroup label={<InputLabel isRequired={true} label="Nazwisko" htmlFor="surname" />}>
            <InputField
                type="text"
                id="surname"
                hasError={!!fieldErrors?.surname}
                errorMessage={fieldErrors?.surname?.message}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('surname', {
                    ...validationRules.required(),
                    ...validationRules.minLength(2),
                })}
            />
        </FormGroup>
        <FormGroup label={<InputLabel isRequired={true} label="Email" htmlFor="email" />}>
            <InputField
                type="text"
                id="email"
                hasError={!!fieldErrors?.email}
                errorMessage={fieldErrors?.email?.message}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('email', {
                    ...validationRules.required(),
                    ...validationRules.minLength(2),
                })}
            />
        </FormGroup>
        <PasswordSection register={register} fieldErrors={fieldErrors} isEditMode={isEditMode} />
        <FormGroup label={<InputLabel label="Telefon" htmlFor="phone" />}>
            <InputField
                type="text"
                id="phone"
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('phone')}
            />
        </FormGroup>
        <FormGroup label={<InputLabel label="Dostępny?" />}>
            <Switch {...register('isActive')} />
        </FormGroup>
        <FormGroup label={<InputLabel label="Dodać adres dostawy?" />}>
            <Switch {...register('isDelivery')} />
        </FormGroup>
    </FormSection>
);

export default CustomerInformation;
