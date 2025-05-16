import React from 'react';
import Input from '../../../common/Input';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import { CheckoutFormData } from '../steps/AddressStep';
import { validationRules } from '../../../../admin/utils/validationRules';
import SectionStepTitle from '../SectionStepTitle';

type Props = {
  register: UseFormRegister<CheckoutFormData>;
  fieldErrors: FieldErrors<CheckoutFormData>;
};

const AddressInvoiceForm: React.FC<Props> = ({register, fieldErrors}) => (
  <>
    <SectionStepTitle title="Adres Faktury" />
    <div className="grid lg:grid-cols-2 grid-cols-1 gap-5 mb-5 mt-5">
      <Input
        {...register('invoiceCompanyName', {
          ...validationRules.minLength(3),
        })}
        id="invoiceCompanyName"
        label="Nazwa firmy"
        hasError={!!fieldErrors?.invoiceCompanyName}
        errorMessage={fieldErrors?.invoiceCompanyName?.message as string | undefined}
      />
      <Input
        {...register('invoiceCompanyTaxId', {
          ...validationRules.minLength(3),
        })}
        id="invoiceCompanyTaxId"
        label="NIP"
        hasError={!!fieldErrors?.invoiceCompanyTaxId}
        errorMessage={fieldErrors?.invoiceCompanyTaxId?.message as string | undefined}
      />
      <Input
        {...register('invoiceStreet', {
          ...validationRules.required(),
          ...validationRules.minLength(3),
        })}
        id="surname"
        label="Ulica"
        hasError={!!fieldErrors?.invoiceStreet}
        errorMessage={fieldErrors?.invoiceStreet?.message as string | undefined}
        isRequired
      />
      <Input
        {...register('invoicePostalCode', {
          ...validationRules.required(),
          ...validationRules.minLength(5),
        })}
        id="invoicePostalCode"
        label="Kod Pocztowy"
        hasError={!!fieldErrors?.invoicePostalCode}
        errorMessage={fieldErrors?.invoicePostalCode?.message as string | undefined}
        isRequired
      />

      <Input
        {...register('invoiceCity', {
          ...validationRules.required(),
          ...validationRules.minLength(2),
        })}
        id="invoiceCity"
        label="Miasto"
        hasError={!!fieldErrors?.invoiceCity}
        errorMessage={fieldErrors?.invoiceCity?.message as string | undefined}
        isRequired
      />

    </div>
  </>
)

export default AddressInvoiceForm;
