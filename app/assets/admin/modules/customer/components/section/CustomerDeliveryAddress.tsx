import FormSection from '@admin/shared/components/form/FormSection';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import InputField from '@admin/shared/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/utils/validationRules';
import Switch from '@admin/shared/components/form/input/Switch';
import React from 'react';

const CustomerDeliveryAddress = ({register, fieldErrors}) => (
  <FormSection title="Adres dostawy">
    <FormGroup
      label={<InputLabel isRequired={true} label="Ulica" htmlFor="street"  />}
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
      label={<InputLabel isRequired={true} label="Miasto" htmlFor="city"  />}
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
      label={<InputLabel isRequired={true} label="Kod pocztowy" htmlFor="postalCode"  />}
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

    <FormGroup label={ <InputLabel label="Dodać fakture?" /> }>
      <Switch {...register('isInvoice')} />
    </FormGroup>

  </FormSection>
)

export default CustomerDeliveryAddress;
