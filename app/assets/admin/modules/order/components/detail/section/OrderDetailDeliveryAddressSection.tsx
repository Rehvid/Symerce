import FormSection from '@admin/common/components/form/FormSection';
import LabelValue from '@admin/common/components/LabelValue';
import React, { FC } from 'react';
import { OrderDetail } from '@admin/modules/order/interfaces/OrderDetail';

interface OrderDetailDeliveryAddressSectionProps {
    delivery: OrderDetail['deliveryAddress'];
}

const OrderDetailDeliveryAddressSection: FC<OrderDetailDeliveryAddressSectionProps> = ({ delivery }) => (
    <FormSection title="Adres Dostawy" useDefaultGap={false} contentContainerClasses="gap-2">
        <LabelValue label="Kod pocztowy" value={delivery?.address?.postalCode} />
        <LabelValue label="Miasto" value={delivery?.address?.city} />
        <LabelValue label="Ulica" value={delivery?.address?.street} />
        <LabelValue label="Instrukcje dla dostawcy" value={delivery?.deliveryInstructions} />
    </FormSection>
);

export default OrderDetailDeliveryAddressSection;
