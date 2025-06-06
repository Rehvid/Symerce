import { OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetailInterface';
import FormSection from '@admin/common/components/form/FormSection';
import React from 'react';
import OrderDetailTableItem from '@admin/modules/order/components/detail/OrderDetailTableItem';

interface OrderDetailItemsSectionProps {
  items: OrderDetailInterface['items']
}

const OrderDetailItemsSection: React.FC<OrderDetailItemsSectionProps> = ({items}) => {
  console.log("Items", items);
  return (
    <FormSection title="Produkty">
      <table className="w-full border-seperate text-left">
        <thead>
        <tr className="text-xs uppercase text-gray-500">
          <th className="py-2 px-4">Produkt</th>
          <th className="py-2 px-4 text-center">Ilość</th>
          <th className="py-2 px-4 text-right">Cena</th>
          <th className="py-2 px-4 text-right">Suma</th>
        </tr>
        </thead>
        <tbody>
        {items?.map((item, key) => (
          <OrderDetailTableItem key={key} item={item} />
        ))}
        </tbody>
      </table>
    </FormSection>
  )
}

export default OrderDetailItemsSection;
