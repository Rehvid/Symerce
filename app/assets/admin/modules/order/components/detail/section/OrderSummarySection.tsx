import LabelValue from '@admin/common/components/LabelValue';
import FormSection from '@admin/common/components/form/FormSection';
import { OrderDetail } from '@admin/modules/order/interfaces/OrderDetail';
import { FC } from 'react';

interface OrderSummarySectionProps {
    summary: OrderDetail['summary']
}

const OrderSummarySection: FC<OrderSummarySectionProps> = ({summary}) => (
    <FormSection title="Podusmowanie" useDefaultGap={false} contentContainerClasses="gap-2">
      <LabelValue label="Wartość produktów" value={summary?.summaryProductPrice} />
      <LabelValue label="Dostawa" value={summary?.deliveryFee} />
      <LabelValue label="Płatność" value={summary?.paymentMethodFee} />
      <LabelValue label="Razem do zapłaty" value={summary?.totalPrice} />
    </FormSection>
)


export default OrderSummarySection;
