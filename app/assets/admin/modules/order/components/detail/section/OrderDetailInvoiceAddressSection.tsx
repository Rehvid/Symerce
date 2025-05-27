import FormSection from '@admin/shared/components/form/FormSection';
import OrderLabelValue from '@admin/modules/order/components/detail/OrderLabelValue';
import React from 'react';


const OrderDetailInvoiceAddressSection = ({invoice}) => {
  return (
    <FormSection title="Faktura" useDefaultGap={false} contentContainerClasses="gap-2">
      <OrderLabelValue label="Nazwa firmy" value={invoice?.companyName} />
      <OrderLabelValue label="Nip" value={invoice?.companyTaxId} />
      <OrderLabelValue label="Kod pocztowy" value={invoice?.address?.postalCode} />
      <OrderLabelValue label="Miasto" value={invoice?.address?.city} />
      <OrderLabelValue label="Ulica" value={invoice?.address?.street} />
    </FormSection>
  )
}

export default OrderDetailInvoiceAddressSection;
