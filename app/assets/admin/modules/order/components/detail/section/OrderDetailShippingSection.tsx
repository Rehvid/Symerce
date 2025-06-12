import FormSection from '@admin/common/components/form/FormSection';
import { OrderDetail } from '@admin/modules/order/interfaces/OrderDetail';
import React from 'react';
import LabelValue from '@admin/common/components/LabelValue';

interface OrderDetailShippingSectionProps {
  shipping: OrderDetail['shipping']
}

const OrderDetailShippingSection: React.FC<OrderDetailShippingSectionProps> = ({shipping}) => {
  return (
    <FormSection title="Dostawa" useDefaultGap={false} contentContainerClasses="gap-2">
      <LabelValue label="Nazwa" value={shipping?.name} />
      <LabelValue label="Opłata" value={shipping?.fee} />
    </FormSection>
  )
}

export default OrderDetailShippingSection;
