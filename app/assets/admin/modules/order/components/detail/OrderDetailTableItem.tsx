import AppLink from '@admin/components/common/AppLink';

const OrderDetailTableItem = ({item}) => {
  return (
    <tr className="mb-3 text-sm odd:bg-gray-50">
      <td className="py-6 px-4">
        {item.editUrl ? (
          <AppLink to={item.editUrl} additionalClasses="font-bold">{item.name}</AppLink>
        ) : (
          <span>{item.name}</span>
        )}
      </td>
      <td className="py-6 px-4 text-center">{item.quantity}</td>
      <td className="py-6 px-4 text-right">{item.unitPrice}</td>
      <td className="py-6 px-4 text-right">{item.totalPrice}</td>
    </tr>
  )
}

export default OrderDetailTableItem;
