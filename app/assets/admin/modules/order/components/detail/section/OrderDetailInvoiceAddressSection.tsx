import FormSection from '@admin/common/components/form/FormSection';
import LabelValue from '@admin/common/components/LabelValue';
import React, { FC } from 'react';
import { OrderDetail } from '@admin/modules/order/interfaces/OrderDetail';

interface OrderDetailInvoiceAddressSectionProps {
    invoice: OrderDetail['invoiceAddress'];
}

const OrderDetailInvoiceAddressSection: FC<OrderDetailInvoiceAddressSectionProps> = ({ invoice }) => (
    <FormSection title="Faktura" useDefaultGap={false} contentContainerClasses="gap-2">
        <LabelValue label="Nazwa firmy" value={invoice?.companyName} />
        <LabelValue label="Nip" value={invoice?.companyTaxId} />
        <LabelValue label="Kod pocztowy" value={invoice?.address?.postalCode} />
        <LabelValue label="Miasto" value={invoice?.address?.city} />
        <LabelValue label="Ulica" value={invoice?.address?.street} />
    </FormSection>
);

export default OrderDetailInvoiceAddressSection;
