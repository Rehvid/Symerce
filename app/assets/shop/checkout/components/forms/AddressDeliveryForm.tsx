import React from 'react';
import Input from '../../../common/Input';
import { validationRules } from '../../../../admin/utils/validationRules';
import { CheckoutFormData } from '../steps/AddressStep';
import { UseFormRegister, FieldErrors } from 'react-hook-form';
import SectionStepTitle from '../SectionStepTitle';


type Props = {
  register: UseFormRegister<CheckoutFormData>;
  fieldErrors: FieldErrors<CheckoutFormData>;
};

const AddressDeliveryForm: React.FC<Props> = ({register, fieldErrors}) => (
  <>
    <div className="grid lg:grid-cols-2 grid-cols-1 gap-5 mb-5">
      <Input
        {...register('firstname', {
          ...validationRules.required(),
          ...validationRules.minLength(3),
        })}
        id="firstname"
        label="Imie"
        hasError={!!fieldErrors?.firstname}
        errorMessage={fieldErrors?.firstname?.message as string | undefined}
        isRequired
      />
      <Input
        {...register('surname', {
          ...validationRules.required(),
          ...validationRules.minLength(3),
        })}
        id="surname"
        label="Nazwisko"
        hasError={!!fieldErrors?.surname}
        errorMessage={fieldErrors?.surname?.message as string | undefined}
        isRequired
      />
      <Input
        {...register('phone', {
          ...validationRules.required(),
          ...validationRules.minLength(9),
        })}
        id="phone"
        label="Numer Telefonu"
        hasError={!!fieldErrors?.phone}
        errorMessage={fieldErrors?.phone?.message as string | undefined}
        isRequired
      />
      <Input
        {...register('email', {
          ...validationRules.required(),
          ...validationRules.minLength(3),
        })}
        id="email"
        label="Adres email"
        hasError={!!fieldErrors?.email}
        errorMessage={fieldErrors?.email?.message as string | undefined}
        isRequired
      />
      <Input
        {...register('street', {
          ...validationRules.required(),
          ...validationRules.minLength(3),
        })}
        id="surname"
        label="Ulica"
        hasError={!!fieldErrors?.street}
        errorMessage={fieldErrors?.street?.message as string | undefined}
        isRequired
      />
      <Input
        {...register('postalCode', {
          ...validationRules.required(),
          ...validationRules.minLength(5),
        })}
        id="postalCode"
        label="Kod Pocztowy"
        hasError={!!fieldErrors?.postalCode}
        errorMessage={fieldErrors?.postalCode?.message as string | undefined}
        isRequired
      />

      <Input
        {...register('city', {
          ...validationRules.required(),
          ...validationRules.minLength(2),
        })}
        id="city"
        label="Miasto"
        hasError={!!fieldErrors?.city}
        errorMessage={fieldErrors?.city?.message as string | undefined}
        isRequired
      />
    </div>
    <div className="flex flex-col  mb-5">
      <label className="mb-2">
        Uwagi
      </label>
      <textarea
        {...register('deliveryInstructions')}
        className="lg:max-w-[400px] lg:min-h-[60px] rounded-lg border border-gray-300 px-2 py-2 transition-all duration-300 focus:border-primary active:border-primary focus:outline-hidden"
      />
    </div>
  </>
)

export default AddressDeliveryForm;
