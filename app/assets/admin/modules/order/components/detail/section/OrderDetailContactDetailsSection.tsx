import { OrderDetail } from '@admin/modules/order/interfaces/OrderDetail';
import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import LabelValue from '@admin/common/components/LabelValue';

interface OrderDetailContactSectionProps {
  contactDetails: OrderDetail['contactDetails'],
}

const OrderDetailContactDetailsSection: React.FC<OrderDetailContactSectionProps> = ({contactDetails}) => (
  <FormSection title="Dane kontaktowe" useDefaultGap={false} contentContainerClasses="gap-2">
    <LabelValue label="Imie" value={contactDetails?.firstname} />
    <LabelValue label="Nazwisko" value={contactDetails?.lastname} />
    <LabelValue label="Email" value={contactDetails?.email} />
    <LabelValue label="Telefon" value={contactDetails?.phone} />
  </FormSection>
)


export default OrderDetailContactDetailsSection;
