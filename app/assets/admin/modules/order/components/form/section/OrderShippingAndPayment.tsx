import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { Control, Controller, FieldErrors } from 'react-hook-form';
import { validationRules } from '@admin/common/utils/validationRules';
import Select from '@admin/common/components/form/select/Select';
import { OrderFormDataInterface } from '@admin/modules/order/interfaces/OrderFormDataInterface';
import { FormContextInterface } from '@admin/common/interfaces/FormContextInterface';

interface OrderShippingAndPaymentProps {
  control: Control<OrderFormDataInterface>;
  fieldErrors: FieldErrors<OrderFormDataInterface>;
  formContext?: FormContextInterface;
}

const OrderShippingAndPayment: React.FC<OrderShippingAndPaymentProps> = ({control, fieldErrors, formContext}) => {
  return (
    <FormSection title="Dostawa i płatność">
      <FormGroup
        label={<InputLabel isRequired={true} label="Metoda płatności" htmlFor="paymentMethodId"  />}
      >
        <Controller
          name="paymentMethodId"
          control={control}
          defaultValue={null}
          rules={{
            ...validationRules.required(),
          }}
          render={({ field }) => (
            <Select
              hasError={!!fieldErrors?.paymentMethodId}
              errorMessage={fieldErrors?.paymentMethodId?.message}
              options={formContext?.availablePaymentMethods || []}
              selected={field.value}
              onChange={(value) => {
                field.onChange(value);
              }}
            />
          )}
        />
      </FormGroup>
      <FormGroup
        label={<InputLabel isRequired={true} label="Dostawca" htmlFor="carrierId"  />}
      >
        <Controller
          name="carrierId"
          control={control}
          defaultValue={null}
          rules={{
            ...validationRules.required(),
          }}
          render={({ field }) => (
            <Select
              hasError={!!fieldErrors?.carrierId}
              errorMessage={fieldErrors?.carrierId?.message}
              options={formContext?.availableCarriers || []}
              selected={field.value}
              onChange={(value) => {
                field.onChange(value);
              }}
            />
          )}
        />
      </FormGroup>
    </FormSection>
  )
}

export default OrderShippingAndPayment;
