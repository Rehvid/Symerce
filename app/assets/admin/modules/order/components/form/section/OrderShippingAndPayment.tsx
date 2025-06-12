import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { Control } from 'react-hook-form';
import { validationRules } from '@admin/common/utils/validationRules';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { OrderFormContext } from '@admin/modules/order/interfaces/OrderFormContext';

interface OrderShippingAndPaymentProps {
  control: Control<OrderFormData>;
  formContext: OrderFormContext;
}

const OrderShippingAndPayment: React.FC<OrderShippingAndPaymentProps> = ({control, formContext}) => {
  return (
    <FormSection title="Dostawa i płatność">
      <FormGroup
        label={<InputLabel isRequired={true} label="Metoda płatności" htmlFor="paymentMethodId"  />}
      >
          <ControlledReactSelect
              name="paymentMethodId"
              control={control}
              options={formContext?.availablePaymentMethods || []}
              rules={{...validationRules.required()}}
          />
      </FormGroup>
      <FormGroup
        label={<InputLabel isRequired={true} label="Dostawca" htmlFor="carrierId"  />}
      >
          <ControlledReactSelect
              name="carrierId"
              control={control}
              options={formContext?.availableCarriers || []}
              rules={{...validationRules.required()}}
          />
      </FormGroup>
    </FormSection>
  )
}

export default OrderShippingAndPayment;
