import { FieldErrors, UseFormRegister } from 'react-hook-form';
import { CountryFormDataInterface } from '@admin/modules/country/interfaces/CountryFormDataInterface';
import React from 'react';
import { hasAnyFieldError } from '@admin/shared/utils/formUtils';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import InputField from '@admin/shared/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/utils/validationRules';
import Switch from '@admin/shared/components/form/input/Switch';
import FormSection from '@admin/shared/components/form/FormSection';
import Description from '@admin/shared/components/Description';

interface CountryFormBodyProps {
  register: UseFormRegister<CountryFormDataInterface>;
  fieldErrors: FieldErrors<CountryFormDataInterface>;
}

const CountryFormBody: React.FC<CountryFormBodyProps> = ({register, fieldErrors}) => {
  return (
    <>
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
              ...validationRules.minLength(3),
            })}
          />
        </FormGroup>
        <FormGroup
          label={<InputLabel isRequired={true} label="Kod kraju" htmlFor="code"  />}
          description={<Description>Kod kraju musi być zgodny z ISO 3166-1 alfa-2</Description>}
        >
          <InputField
            type="text"
            id="code"
            hasError={!!fieldErrors?.code}
            errorMessage={fieldErrors?.code?.message}
            icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
            {...register('code', {
              ...validationRules.required(),
              ...validationRules.max(2)
            })}
          />
        </FormGroup>
        <FormGroup label={ <InputLabel label="Czy jest aktywne?" /> }>
          <Switch {...register('isActive')} />
        </FormGroup>
      </FormSection>
    </>
  )
}

export default CountryFormBody;
