import React from 'react';
import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';
import OrderLabelValue from '@admin/modules/order/components/detail/OrderLabelValue';
import FormSection from '@admin/common/components/form/FormSection';

interface OrderDetailInfoSectionProps {
  information: OrderDetailInterface['information'];
}

const OrderDetailInfoSection: React.FC<OrderDetailInfoSectionProps> = ({ information }) => {
  return (
    <FormSection title="Informacje" useDefaultGap={false} contentContainerClasses="gap-2" >
      <OrderLabelValue label="Id" value={information.id} />
      <OrderLabelValue label="Uuid" value={information.uuid} />
      <OrderLabelValue label="Status" value={information.orderStatus} />
      <OrderLabelValue label="Krok w koszyku" value={information.checkoutStatus} />
      <OrderLabelValue label="Utworzono" value={information.createdAt} />
      <OrderLabelValue label="Ostatnia aktualizacja" value={information.updatedAt} />
    </FormSection>
  )
}

export default OrderDetailInfoSection;
