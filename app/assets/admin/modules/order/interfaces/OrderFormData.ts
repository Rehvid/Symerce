import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { CheckoutItem } from '@admin/common/types/checkoutItem';
import { AddressDelivery } from '@admin/common/interfaces/AddressDelivery';
import { AddressInvoice } from '@admin/common/interfaces/AddressInvoice';

export interface OrderFormData extends FormDataInterface, AddressDelivery, AddressInvoice {
    checkoutStep: string;
    status: string;
    uuid?: string;
    carrierId?: number;
    paymentMethodId?: number;
    isInvoice: boolean;
    firstname?: string;
    surname?: string;
    email?: string;
    phone?: string | number;
    companyName?: string;
    companyTaxId?: string;
    products?: CheckoutItem[];
    useCustomer?: boolean;
    customerId?: number | null;
}
