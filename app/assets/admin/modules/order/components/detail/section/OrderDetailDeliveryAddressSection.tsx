import FormSection from '@admin/common/components/form/FormSection';
import OrderLabelValue from '@admin/modules/order/components/detail/OrderLabelValue';
import React from 'react';


const OrderDetailDeliveryAddressSection = ({delivery}) => {
  return (
    <FormSection title="Adres Dostawy" useDefaultGap={false} contentContainerClasses="gap-2">
      <OrderLabelValue label="Kod pocztowy" value={delivery?.address?.postalCode} />
      <OrderLabelValue label="Miasto" value={delivery?.address?.city} />
      <OrderLabelValue label="Ulica" value={delivery?.address?.street} />
      <OrderLabelValue label="Instrukcje dla dostawcy" value={delivery?.address?.deliveryInstructions} />
    </FormSection>
  )
}

export default OrderDetailDeliveryAddressSection;
