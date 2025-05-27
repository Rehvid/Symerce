import OrderLabelValue from '@admin/modules/order/components/detail/OrderLabelValue';
import FormSection from '@admin/shared/components/form/FormSection';

const OrderSummarySection = ({summary}) => {
  return (
    <FormSection title="Podusmowanie" useDefaultGap={false} contentContainerClasses="gap-2">
      <OrderLabelValue label="Wartość produktów" value={summary.summaryProductPrice} />
      <OrderLabelValue label="Dostawa" value={summary.deliveryFee} />
      <OrderLabelValue label="Płatność" value={summary.paymentMethodFee} />
      <OrderLabelValue label="Razem do zapłaty" value={summary.totalPrice} />
    </FormSection>
  )
}

export default OrderSummarySection;
