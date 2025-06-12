import React  from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import { Control,  FieldErrors, UseFormRegister } from 'react-hook-form';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { OrderFormContext } from '@admin/modules/order/interfaces/OrderFormContext';

interface OrderInvoiceAddressProps {
  register: UseFormRegister<OrderFormData>,
  fieldErrors: FieldErrors<OrderFormData>;
  control: Control<OrderFormData>;
  formContext: OrderFormContext,
}

const OrderInvoiceAddress: React.FC<OrderInvoiceAddressProps> = ({
    register,
    fieldErrors,
    control,
    formContext,
}) => (
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
        label={<InputLabel label="Nazwa firmy" htmlFor="invoiceCompanyName"  />}
      >
        <InputField
          type="text"
          id="invoiceCompanyName"
          hasError={!!fieldErrors?.invoiceCompanyName}
          errorMessage={fieldErrors?.invoiceCompanyName?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('invoiceCompanyName')}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel label="NIP" htmlFor="invoiceCompanyTaxId"  />}
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
              rules={{...validationRules.required()}}
          />
      </FormGroup>
    </FormSection>)


export default OrderInvoiceAddress;
