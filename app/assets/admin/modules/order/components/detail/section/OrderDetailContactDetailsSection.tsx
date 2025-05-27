import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';
import React from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import OrderLabelValue from '@admin/modules/order/components/detail/OrderLabelValue';

interface OrderDetailContactSectionProps {
  contactDetails: OrderDetailInterface['contactDetails'],
  delivery: OrderDetailInterface['deliveryAddress'],
  invoice:  OrderDetailInterface['invoiceAddress']
}

const OrderDetailContactDetailsSection: React.FC<OrderDetailContactSectionProps> = ({contactDetails, delivery, invoice}) => {

    return (
      <FormSection title="Dane kontaktowe" useDefaultGap={false} contentContainerClasses="gap-2">
        <OrderLabelValue label="Imie" value={contactDetails?.firstname} />
        <OrderLabelValue label="Nazwisko" value={contactDetails?.lastname} />
        <OrderLabelValue label="Email" value={contactDetails?.email} />
        <OrderLabelValue label="Telefon" value={contactDetails?.phone} />
      </FormSection>
    )
}

export default OrderDetailContactDetailsSection;
