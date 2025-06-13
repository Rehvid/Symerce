import FormSection from '@admin/common/components/form/FormSection';
import { OrderDetail } from '@admin/modules/order/interfaces/OrderDetail';
import React from 'react';
import OrderDetailTablePaymentItem from '@admin/modules/order/components/detail/OrderDetailTablePaymentItem';

interface OrderDetailPaymentSectionProps {
    payment: OrderDetail['payment'];
}

const OrderDetailPaymentSection: React.FC<OrderDetailPaymentSectionProps> = ({ payment }) => (
    <FormSection title="Płatności">
        <table className="w-full border-seperate text-left">
            <thead>
                <tr className="text-xs uppercase text-gray-500">
                    <th className="py-2 px-4">Płatność</th>
                    <th className="py-2 px-4 text-center">Cena</th>
                    <th className="py-2 px-4 text-right">Status</th>
                    <th className="py-2 px-4 text-right">ID transakcji</th>
                    <th className="py-2 px-4 text-right">Data transakcji</th>
                </tr>
            </thead>
            <tbody>
                {payment?.paymentMethodCollection?.map((item, key) => (
                    <OrderDetailTablePaymentItem key={key} item={item} />
                ))}
            </tbody>
        </table>
    </FormSection>
);

export default OrderDetailPaymentSection;
