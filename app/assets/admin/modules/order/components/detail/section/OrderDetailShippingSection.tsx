import FormSection from '@admin/shared/components/form/FormSection';
import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';
import React from 'react';
import OrderLabelValue from '@admin/modules/order/components/detail/OrderLabelValue';

interface OrderDetailShippingSectionProps {
  shipping: OrderDetailInterface['shipping']
}

const OrderDetailShippingSection: React.FC<OrderDetailShippingSectionProps> = ({shipping}) => {
  return (
    <FormSection title="Dostawa" useDefaultGap={false} contentContainerClasses="gap-2">
      <OrderLabelValue label="Nazwa" value={shipping?.name} />
      <OrderLabelValue label="Opłata" value={shipping?.fee} />
    </FormSection>
  )
}

export default OrderDetailShippingSection;
