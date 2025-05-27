import { FormDataInterface } from '@admin/shared/interfaces/FormDataInterface';
import { CheckoutItem } from '@admin/shared/types/checkoutItem';

export interface OrderFormDataInterface extends FormDataInterface {
  checkoutStep: string,
  status: string,
  uuid?: string,
  carrierId?: number,
  paymentMethodId?: number,
  isInvoice: boolean,
  firstname?: string,
  surname?: string,
  email?: string,
  phone?: string | number,
  postalCode?: string,
  city?: string,
  street?: string,
  deliveryInstructions?: string,
  invoiceStreet?: string,
  invoiceCity?: string,
  invoicePostalCode?: string,
  companyName?: string,
  companyTaxId?: string,
  products?: CheckoutItem[]
}
