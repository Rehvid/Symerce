import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import { Controller } from 'react-hook-form';
import ReactSelect from '@admin/common/components/form/reactSelect/ReactSelect';
import React, { useState } from 'react';
import Switch from '@admin/common/components/form/input/Switch';

const WarehouseFormBody = ({register, fieldErrors, control, formContext, formData}) => {
  const [isDefaultOptionSelected, setIsDefaultOptionSelected] = useState<boolean>(false);
  const availableOptions = formContext?.availableCountries;
  const selectedOption = availableOptions?.find(option => option.value === formData?.country);

  return (
    <FormSection title="Informacje" >
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

      <FormGroup
        label={<InputLabel label="Opis" htmlFor="description"  />}
      >
        <textarea {...register('description')} className="w-full rounded-lg border border-gray-300 p-2 transition-all focus:ring-4 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light" />
      </FormGroup>

      <FormGroup
        label={<InputLabel isRequired={true} label="Ulica" htmlFor="street" />}
      >
        <InputField
          type="text"
          id="street"
          hasError={!!fieldErrors?.street}
          errorMessage={fieldErrors?.street?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('street', {
            ...validationRules.required(),
            ...validationRules.minLength(3),
          })}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel isRequired={true} label="Miasto" htmlFor="city" />}
      >
        <InputField
          type="text"
          id="city"
          hasError={!!fieldErrors?.city}
          errorMessage={fieldErrors?.city?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('city', {
            ...validationRules.required(),
            ...validationRules.minLength(3),
          })}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel isRequired={true} label="Kod pocztowy" htmlFor="postalCode" />}
      >
        <InputField
          type="text"
          id="postalCode"
          hasError={!!fieldErrors?.postalCode}
          errorMessage={fieldErrors?.postalCode?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('postalCode', {
            ...validationRules.required(),
            ...validationRules.minLength(3),
          })}
        />
      </FormGroup>


      <FormGroup label={<InputLabel label="Kraj" isRequired={true} />}>
        <Controller
          name="country"
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

export default WarehouseFormBody;
