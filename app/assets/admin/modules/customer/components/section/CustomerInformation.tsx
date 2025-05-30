import FormSection from '@admin/shared/components/form/FormSection';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import InputField from '@admin/shared/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/utils/validationRules';
import React from 'react';
import InputPassword from '@admin/shared/components/form/input/InputPassword';
import Switch from '@admin/shared/components/form/input/Switch';

const CustomerInformation = ({register, fieldErrors, isEditMode}) => (
  <FormSection title="Informacje" >
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
      label={<InputLabel label="Telefon" htmlFor="phone"  />}
    >
      <InputField
        type="text"
        id="phone"
        icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
        {...register('phone')}
      />
    </FormGroup>
    <FormGroup
      label={<InputLabel isRequired={true} label="Hasło" htmlFor="password"  />}
    >
      <InputPassword
        id="password"
        isRequired={!isEditMode}
        hasError={!!fieldErrors?.password}
        errorMessage={fieldErrors?.password?.message}
        {...register('password', {
          ...validationRules.password(),
        })}
      />
    </FormGroup>
    <FormGroup
      label={<InputLabel isRequired={true} label="Powtórz hasło" htmlFor="passwordConfirmation"  />}
    >
      <InputPassword
        id="password-confirmation"
        isRequired={!isEditMode}
        hasError={!!fieldErrors?.passwordConfirmation}
        errorMessage={fieldErrors?.passwordConfirmation?.message}
        {...register('passwordConfirmation', {
          validate(passwordConfirmation, { password }) {
            return passwordConfirmation === password || 'Hasła muszą być identyczne.';
          },
        })}
      />
    </FormGroup>
    <FormGroup label={ <InputLabel label="Dostępny?" /> }>
      <Switch {...register('isActive')} />
    </FormGroup>
    <FormGroup label={ <InputLabel label="Dodać adres dostawy?" /> }>
      <Switch {...register('isDelivery')} />
    </FormGroup>


  </FormSection>
)

export default CustomerInformation;
