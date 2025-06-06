import FormSection from '@admin/common/components/form/FormSection';
import OrderLabelValue from '@admin/modules/order/components/detail/OrderLabelValue';
import React from 'react';

const CartDetailInformationSection = ({item}) => {
  return (
    <FormSection title="Informacje" useDefaultGap={false} contentContainerClasses="gap-2" >
      <OrderLabelValue label="Id" value={item.id} />
      <OrderLabelValue label="Klient" value={item.customer} />
      <OrderLabelValue label="Data utworzenia" value={item.createdAt} />
      <OrderLabelValue label="Ostatnia aktualizacja" value={item.updatedAt} />
      <OrderLabelValue label="Koszyk ważny do" value={item.expiresAt} />
    </FormSection>
  )
}

export default CartDetailInformationSection;
