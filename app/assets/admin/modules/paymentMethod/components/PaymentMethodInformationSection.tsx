import FormSection from '@admin/common/components/form/FormSection';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Description from '@admin/common/components/Description';
import CurrencyIcon from '@/images/icons/currency.svg';
import Switch from '@admin/common/components/form/input/Switch';
import React, { FC } from 'react';
import { useAppData } from '@admin/common/context/AppDataContext';
import { FieldErrors, UseFormRegister, UseFormSetValue } from 'react-hook-form';
import { PaymentMethodFormData } from '@admin/modules/paymentMethod/interfaces/PaymentMethodFormData';
import SingleImageUploader from '@admin/common/components/form/SingleImageUploader';

interface PaymentMethodInformationSectionProps {
    register: UseFormRegister<PaymentMethodFormData>;
    fieldErrors: FieldErrors<PaymentMethodFormData>;
    setValue: UseFormSetValue<PaymentMethodFormData>;
    formData: PaymentMethodFormData;
}

const PaymentMethodInformationSection: FC<PaymentMethodInformationSectionProps> = ({register, fieldErrors, setValue, formData}) => {
  const { currency } = useAppData();

  return (
    <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
        <SingleImageUploader
            label="Miniaturka"
            fieldName="thumbnail"
            setValue={setValue}
            initialValue={formData?.thumbnail}
        />
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
        label={<InputLabel isRequired={true} label="Kod" htmlFor="code"  />}
        description={<Description>Unikatowa nazwa widoczna tylko w panelu.</Description>}
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
        label={<InputLabel isRequired={true} label="Prowizja" htmlFor="fee"  />}
      >
        <InputField
          type="text"
          id="fee"
          hasError={!!fieldErrors?.fee}
          errorMessage={fieldErrors?.fee?.message}
          icon={<CurrencyIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('fee', {
            ...validationRules.required(),
            ...validationRules.numeric(currency?.roundingPrecision),
          })}
        />
      </FormGroup>

      <FormGroup label={ <InputLabel label="Aktywny?" /> }>
        <Switch {...register('isActive')} />
      </FormGroup>

      <FormGroup label={ <InputLabel label="Czy wymaga webhook?" /> }>
        <Switch {...register('isRequireWebhook')} />
      </FormGroup>
    </FormSection>
  )
}






export default PaymentMethodInformationSection;
