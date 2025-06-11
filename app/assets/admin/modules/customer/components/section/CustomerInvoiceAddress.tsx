import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React, { FC } from 'react';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import { CustomerFormData } from '@admin/modules/customer/interfaces/CustomerFormData';
import { CustomerFormContext } from '@admin/modules/customer/interfaces/CustomerFormContext';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';

interface CustomerInvoiceAddressProps {
    register: UseFormRegister<CustomerFormData>,
    fieldErrors: FieldErrors<CustomerFormData>,
    control: Control<CustomerFormData>,
    formContext: CustomerFormContext
}

const CustomerInvoiceAddress: FC<CustomerInvoiceAddressProps> = ({fieldErrors, register, control, formContext }) => {

  return (
    <FormSection title="Faktura">
      <FormGroup
        label={<InputLabel isRequired={true} label="Ulica" htmlFor="street"  />}
      >
        <InputField
          type="text"
          id="invoiceStreet"
          hasError={!!fieldErrors?.invoiceStreet}
          errorMessage={fieldErrors?.invoiceStreet?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('invoiceStreet', {
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
          id="invoiceCity"
          hasError={!!fieldErrors?.invoiceCity}
          errorMessage={fieldErrors?.invoiceCity?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('invoiceCity', {
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
          id="invoicePostalCode"
          hasError={!!fieldErrors?.invoicePostalCode}
          errorMessage={fieldErrors?.invoicePostalCode?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('invoicePostalCode', {
            ...validationRules.required(),
            ...validationRules.minLength(3),
          })}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel label="Nazwa firmy" htmlFor="CompanyId"  />}
      >
        <InputField
          type="text"
          id="invoiceCompanyId"
          hasError={!!fieldErrors?.invoiceCompanyName}
          errorMessage={fieldErrors?.invoiceCompanyName?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('invoiceCompanyName')}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel label="NIP" htmlFor="CompanyTaxId"  />}
      >
        <InputField
          type="text"
          id="invoiceCompanyTaxId"
          hasError={!!fieldErrors?.invoiceCompanyTaxId}
          errorMessage={fieldErrors?.invoiceCompanyTaxId?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('invoiceCompanyTaxId')}
        />
      </FormGroup>

      <FormGroup label={<InputLabel label="Kraj" />}>
          <ControlledReactSelect
              name="invoiceCountry"
              control={control}
              options={formContext?.availableCountries}
              rules={{
                  ...validationRules.required()
              }}
          />
      </FormGroup>
    </FormSection>
  )
}


export default CustomerInvoiceAddress;
