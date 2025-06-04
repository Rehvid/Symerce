import FormSection from '@admin/shared/components/form/FormSection';
import OrderDetailTableItem from '@admin/modules/order/components/detail/OrderDetailTableItem';
import React from 'react';

const CartDetailItemsSection = ({items}) => {
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

export default CartDetailItemsSection;
