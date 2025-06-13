import { Address } from '@admin/common/types/address';
import { LineItem } from '@admin/common/components/lineItems/LineItem';

export interface OrderPaymentMethodCollection {
    id: number;
    paidAt?: string;
    amount?: string;
    gatewayTransactionId?: string;
    paymentMethodName: string;
    paymentStatus: string;
}

export interface OrderDetail {
    information: {
        id: number;
        uuid: string;
        cartToken: string;
        orderStatus: string;
        checkoutStatus: string;
        createdAt: string;
        updatedAt: string;
    };
    contactDetails?: {
        email?: string;
        firstname?: string;
        lastname?: string;
        phone?: string | number;
    };
    deliveryAddress?: {
        address: Address;
        deliveryInstructions?: string;
    };
    invoiceAddress?: {
        address: Address;
        companyName?: string;
        companyTaxId?: string | number;
    };
    shipping?: {
        id: number;
        name: string;
        fee: string;
    };
    payment?: {
        paymentMethod: string;
        paymentMethodCollection: OrderPaymentMethodCollection[];
    };
    items?: {
        itemCollection?: LineItem[];
    };
    summary?: {
        deliveryFee?: string;
        paymentMethodFee?: string;
        summaryProductPrice?: string;
        totalPrice?: string;
    };
}
