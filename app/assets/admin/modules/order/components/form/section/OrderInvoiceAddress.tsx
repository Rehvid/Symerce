import React from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import InputField from '@admin/shared/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/utils/validationRules';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import { OrderFormDataInterface } from '@admin/modules/order/interfaces/OrderFormDataInterface';

interface OrderInvoiceAddressProps {
  register: UseFormRegister<OrderFormDataInterface>,
  fieldErrors: FieldErrors<OrderFormDataInterface>;
}

const OrderInvoiceAddress: React.FC<OrderInvoiceAddressProps> = ({register, fieldErrors}) => {
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
          hasError={!!fieldErrors?.invoiceCompanyId}
          errorMessage={fieldErrors?.invoiceCompanyId?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
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
        />
      </FormGroup>
    </FormSection>
  )
}

export default OrderInvoiceAddress;
