import FormSection from '@admin/common/components/form/FormSection';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
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

interface AttributeFormBodyProps {
    register: UseFormRegister<AttributeFormData>,
    fieldErrors: FieldErrors<AttributeFormData>,
    formContext: AttributeFormContext,
    control: Control<AttributeFormData>,
}

const AttributeFormBody: FC<AttributeFormBodyProps> = ({register, fieldErrors, formContext, control}) => {


  return (
  <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>

    <FormGroup
      label={<InputLabel isRequired={true} label="Nazwa" htmlFor="name"  />}
    >
      <InputField
        type="text"
        id="name"
        hasError={!!fieldErrors?.name}
        errorMessage={fieldErrors?.name?.message}
        icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
        {...register('name', {
          ...validationRules.required(),
          ...validationRules.minLength(2),
        })}
      />
    </FormGroup>

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

    <FormGroup label={ <InputLabel label="Aktywny?" /> }>
      <Switch {...register('isActive')} />
    </FormGroup>
  </FormSection>
  )
}

export default AttributeFormBody;
