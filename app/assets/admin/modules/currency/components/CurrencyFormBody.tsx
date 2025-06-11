import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React, { FC } from 'react';
import NumberIcon from '@/images/icons/number.svg';
import FormSection from '@admin/common/components/form/FormSection';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import { CurrencyFormData } from '@admin/modules/currency/interfaces/CurrencyFormData';

interface CurrencyFormBodyProps {
  register: UseFormRegister<CurrencyFormData>;
  fieldErrors: FieldErrors<CurrencyFormData>;
}

const CurrencyFormBody: FC<CurrencyFormBodyProps> = ({register, fieldErrors}) => {
  return (
    <FormSection title="Informacje">
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
        label={<InputLabel isRequired={true} label="Kod" htmlFor="code"  />}
      >
        <InputField
          type="text"
          id="code"
          hasError={!!fieldErrors?.code}
          errorMessage={fieldErrors?.code?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('code', {
            ...validationRules.required(),
          })}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel isRequired={true} label="Symbol" htmlFor="symbol"  />}
      >
        <InputField
          type="text"
          id="symbol"
          hasError={!!fieldErrors?.symbol}
          errorMessage={fieldErrors?.symbol?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('symbol', {
            ...validationRules.required(),
          })}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel isRequired={true} label="Precyzja zaokrąglenia" htmlFor="roundingPrecision"  />}
      >
        <InputField
          type="number"
          id="roundingPrecision"
          hasError={!!fieldErrors?.roundingPrecision}
          errorMessage={fieldErrors?.roundingPrecision?.message}
          icon={<NumberIcon className="text-gray-500 w-[24px] h-[24px]" />}
          {...register('roundingPrecision', {
            ...validationRules.required(),
            ...validationRules.min(0),
            ...validationRules.max(8),
          })}
        />
      </FormGroup>
    </FormSection>
  )
}

export default CurrencyFormBody;
