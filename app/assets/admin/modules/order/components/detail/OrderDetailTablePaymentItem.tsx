

const OrderDetailTablePaymentItem = ({item}) => {
  return (
    <tr className="mb-3 text-sm odd:bg-gray-50">
      <td className="py-6 px-4">{item.paymentMethodName}</td>
      <td className="py-6 px-4 text-center">{item.amount}</td>
      <td className="py-6 px-4 text-right">{item.paymentStatus}</td>
      <td className="py-6 px-4 text-right">{item.gatewayTransactionId ?? '-'}</td>
      <td className="py-6 px-4 text-right">{item.paidAt ?? '-'}</td>
    </tr>
  )
}

export default OrderDetailTablePaymentItem;
