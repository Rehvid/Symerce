import React from 'react';
import { OrderDetail } from '@admin/modules/order/interfaces/OrderDetail';
import LabelValue from '@admin/common/components/LabelValue';
import FormSection from '@admin/common/components/form/FormSection';

interface OrderDetailInformationSectionProps {
    information: OrderDetail['information'];
}

const OrderDetailInformationSection: React.FC<OrderDetailInformationSectionProps> = ({ information }) => (
    <FormSection title="Informacje" useDefaultGap={false} contentContainerClasses="gap-2">
        <LabelValue label="Id" value={information.id} />
        <LabelValue label="Uuid" value={information.uuid} />
        <LabelValue label="Status" value={information.orderStatus} />
        <LabelValue label="Krok w koszyku" value={information.checkoutStatus} />
        <LabelValue label="Utworzono" value={information.createdAt} />
        <LabelValue label="Ostatnia aktualizacja" value={information.updatedAt} />
    </FormSection>
);

export default OrderDetailInformationSection;
