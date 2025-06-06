import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Switch from '@admin/common/components/form/input/Switch';
import React, { useState } from 'react';
import ReactSelect from '@admin/common/components/form/reactSelect/ReactSelect';
import { Controller } from 'react-hook-form';

const CustomerDeliveryAddress = ({register, fieldErrors, control, formContext, formData}) => {
  const [isDefaultOptionSelected, setIsDefaultOptionSelected] = useState<boolean>(false);
  const availableOptions = formContext?.availableCountries;
  const selectedOption = availableOptions?.find(option => option.value === formData?.country);


  return (
    <FormSection title="Adres dostawy">
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

      <FormGroup label={<InputLabel label="Dodać fakture?" />}>
        <Switch {...register('isInvoice')} />
      </FormGroup>

    </FormSection>
  )
}

export default CustomerDeliveryAddress;
