import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import React, { FC } from 'react';
import Switch from '@admin/common/components/form/input/Switch';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { WarehouseFormData } from '@admin/modules/warehouse/interfaces/WarehouseFormData';
import { WarehouseFormContext } from '@admin/modules/warehouse/interfaces/WarehouseFormContext';
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';
import TextareaField from '@admin/common/components/form/input/TextareaField';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';
import AddressDeliveryFields from '@admin/common/components/form/fields/formGroup/AddressDeliveryFields';

interface WarehouseFormBodyProps {
    register: UseFormRegister<WarehouseFormData>;
    fieldErrors: FieldErrors<WarehouseFormData>;
    control: Control<WarehouseFormData>;
    formContext: WarehouseFormContext;
}

const WarehouseFormBody: FC<WarehouseFormBodyProps> = ({ register, fieldErrors, control, formContext }) => {
    return (
        <FormSection title="Informacje" useToggleContent={false}>
            <GenericTextField register={register} fieldErrors={fieldErrors} fieldName="name" label="Nazwa" isRequired={true} />

            <FormGroup label={<InputLabel label="Opis" htmlFor="description" />}>
                <TextareaField {...register('description')} />
            </FormGroup>

            <AddressDeliveryFields
                register={register}
                control={control}
                fieldErrors={fieldErrors}
                availableCountries={formContext?.availableCountries}
                useDeliveryInstructions={false}
            />

            <FormSwitchField register={register} name="isActive" label="Aktywny" />
        </FormSection>
    );
};

export default WarehouseFormBody;
