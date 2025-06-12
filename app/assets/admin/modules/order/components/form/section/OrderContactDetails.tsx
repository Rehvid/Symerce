import React from 'react';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import FormSection from '@admin/common/components/form/FormSection';

interface OrderContactDetailsProps {
  register: UseFormRegister<OrderFormData>,
  fieldErrors: FieldErrors<OrderFormData>;
}

const OrderContactDetails: React.FC<OrderContactDetailsProps> = ({register, fieldErrors}) => {
  return (
    <FormSection title="Informacje kontaktowe" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>

      <FormGroup
        label={<InputLabel isRequired={true} label="Imie" htmlFor="firstname"  />}
      >
        <InputField
          type="text"
          id="firstname"
          hasError={!!fieldErrors?.firstname}
          errorMessage={fieldErrors?.firstname?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('firstname', {
            ...validationRules.required(),
            ...validationRules.minLength(3),
          })}
        />
      </FormGroup>
      <FormGroup
        label={<InputLabel isRequired={true} label="Nazwisko" htmlFor="surname"  />}
      >
        <InputField
          type="text"
          id="surname"
          hasError={!!fieldErrors?.surname}
          errorMessage={fieldErrors?.surname?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('surname', {
            ...validationRules.required(),
            ...validationRules.minLength(3),
          })}
        />
      </FormGroup>
      <FormGroup
        label={<InputLabel isRequired={true} label="Email" htmlFor="email"  />}
      >
        <InputField
          type="text"
          id="email"
          hasError={!!fieldErrors?.email}
          errorMessage={fieldErrors?.email?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('email', {
            ...validationRules.required(),
            ...validationRules.minLength(3),
          })}
        />
      </FormGroup>
      <FormGroup
        label={<InputLabel isRequired={true} label="Telefon" htmlFor="phone"  />}
      >
        <InputField
          type="text"
          id="phone"
          hasError={!!fieldErrors?.phone}
          errorMessage={fieldErrors?.phone?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('phone', {
            ...validationRules.required(),
            ...validationRules.minLength(3),
          })}
        />
      </FormGroup>
    </FormSection>
  )
}

export default OrderContactDetails;
