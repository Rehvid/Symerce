import OrderDetailInformationSection from '@admin/modules/order/components/detail/section/OrderDetailInformationSection';
import OrderDetailContactDetailsSection from '@admin/modules/order/components/detail/section/OrderDetailContactDetailsSection';
import OrderDetailDeliveryAddressSection from '@admin/modules/order/components/detail/section/OrderDetailDeliveryAddressSection';
import OrderDetailShippingSection from '@admin/modules/order/components/detail/section/OrderDetailShippingSection';
import OrderDetailPaymentSection from '@admin/modules/order/components/detail/section/OrderDetailPaymentSection';
import React from 'react';
import { OrderDetail } from '@admin/modules/order/interfaces/OrderDetail';
import OrderDetailInvoiceAddressSection
  from '@admin/modules/order/components/detail/section/OrderDetailInvoiceAddressSection';
import OrderSummarySection from '@admin/modules/order/components/detail/section/OrderSummarySection';
import LineItemsTableSection from '@admin/common/components/lineItems/LineItemsTableSection';

interface OrderDetailBodyProps {
  detailData: OrderDetail
}

const OrderDetailBody: React.FC<OrderDetailBodyProps> = ({ detailData }) => {
  return (
    <div className="py-4 flex flex-col gap-5 ">
        <OrderDetailInformationSection information={detailData.information} />
        <LineItemsTableSection title="Produkty" items={detailData.items?.itemCollection || []}  />
        <OrderSummarySection summary={detailData.summary} />
        <OrderDetailPaymentSection payment={detailData.payment} />
        <OrderDetailContactDetailsSection contactDetails={detailData.contactDetails} />
        <OrderDetailDeliveryAddressSection delivery={detailData.deliveryAddress} />
        <OrderDetailInvoiceAddressSection invoice={detailData.invoiceAddress} />
        <OrderDetailShippingSection shipping={detailData.shipping} />
    </div>
  )
}

export default OrderDetailBody;
