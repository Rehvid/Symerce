import FormSection from '@admin/common/components/form/FormSection';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Switch from '@admin/common/components/form/input/Switch';
import React, { useState } from 'react';
import { Controller } from 'react-hook-form';
import ReactSelect from '@admin/common/components/form/reactSelect/ReactSelect';

const AttributeFormBody = ({register, fieldErrors, formContext, formData, control}) => {
  const [isDefaultOptionSelected, setIsDefaultOptionSelected] = useState<boolean>(false);
  const availableOptions = formContext?.availableTypes;
  const selectedOption = availableOptions?.find(option => option.value === formData?.type);

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
      <Controller
        name="type"
        control={control}
        defaultValue={selectedOption}
        rules={{
          ...validationRules.required()
        }}
        render={({ field, fieldState }) => (
          <ReactSelect
            options={availableOptions}
            value={isDefaultOptionSelected ? field.value : selectedOption}
            onChange={(option) => {
              setIsDefaultOptionSelected(true);
              field.onChange(option);
            }}
            hasError={fieldState.invalid}
            errorMessage={fieldState.error?.message}
          />
        )}

      />
    </FormGroup>

    <FormGroup label={ <InputLabel label="Aktywny?" /> }>
      <Switch {...register('isActive')} />
    </FormGroup>
  </FormSection>
  )
}

export default AttributeFormBody;
