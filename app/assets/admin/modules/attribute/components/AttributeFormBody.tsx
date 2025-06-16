import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Switch from '@admin/common/components/form/input/Switch';
import React, { FC } from 'react';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { AttributeFormData } from '@admin/modules/attribute/interfaces/AttributeFormData';
import { AttributeFormContext } from '@admin/modules/attribute/interfaces/AttributeFormContext';
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';

interface AttributeFormBodyProps {
    register: UseFormRegister<AttributeFormData>;
    fieldErrors: FieldErrors<AttributeFormData>;
    formContext: AttributeFormContext;
    control: Control<AttributeFormData>;
}

const AttributeFormBody: FC<AttributeFormBodyProps> = ({ register, fieldErrors, formContext, control }) => {
    return (
        <FormSection title="Informacje" useToggleContent={false}>
            <GenericTextField register={register} fieldErrors={fieldErrors} fieldName={"name"} label={"Nazwa"} isRequired={true} />

            <FormGroup label={<InputLabel label="Typ" isRequired={true} />}>
                <ControlledReactSelect
                    name="type"
                    control={control}
                    options={formContext?.availableTypes}
                    rules={{
                        ...validationRules.required(),
                    }}
                />
            </FormGroup>

            <FormSwitchField register={register} name="isActive" fieldErrors={fieldErrors} label="Aktywny" />
        </FormSection>
    );
};

export default AttributeFormBody;
