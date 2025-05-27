import OrderDetailInfoSection from '@admin/modules/order/components/detail/section/OrderDetailInfoSection';
import OrderDetailContactDetailsSection from '@admin/modules/order/components/detail/section/OrderDetailContactDetailsSection';
import OrderDetailDeliveryAddressSection from '@admin/modules/order/components/detail/section/OrderDetailDeliveryAddressSection';
import OrderDetailShippingSection from '@admin/modules/order/components/detail/section/OrderDetailShippingSection';
import OrderDetailPaymentSection from '@admin/modules/order/components/detail/section/OrderDetailPaymentSection';
import OrderDetailItemsSection from '@admin/modules/order/components/detail/section/OrderDetailItemsSection';
import React from 'react';
import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';
import OrderDetailInvoiceAddressSection
  from '@admin/modules/order/components/detail/section/OrderDetailInvoiceAddressSection';
import OrderSummarySection from '@admin/modules/order/components/detail/section/OrderSummarySection';

interface OrderDetailBodyProps {
  items: OrderDetailInterface
}

const OrderDetailBody: React.FC<OrderDetailBodyProps> = ({ items }) => {
  return (
    <div className="py-4 flex lg:flex-row flex-col gap-5 ">
      <div className="w-full lg:w-96">
        <OrderDetailInfoSection  information={items.information} />
        <OrderDetailContactDetailsSection contactDetails={items.contactDetails} delivery={items.deliveryAddress} invoice={items.invoiceAddress}/>
        <OrderDetailDeliveryAddressSection delivery={items.deliveryAddress} />
        <OrderDetailInvoiceAddressSection invoice={items.invoiceAddress} />
        <OrderDetailShippingSection shipping={items.shipping} />
      </div>
      <div className="mt-4 w-full flex-1 lg:mt-0">
        <OrderDetailItemsSection items={items.items?.itemCollection || []} />
        <OrderSummarySection summary={items.summary} />
        <OrderDetailPaymentSection payment={items.payment} />
      </div>
    </div>
  )
}

export default OrderDetailBody;
