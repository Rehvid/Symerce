import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { CheckoutItem } from '@admin/common/types/checkoutItem';

export interface OrderFormData extends FormDataInterface {
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
  invoiceCountry?: number | null;
  invoiceCompanyName?: string | null,
  invoiceCompanyTaxId?: string | null,
  companyName?: string,
  companyTaxId?: string,
  products?: CheckoutItem[];
  country: number;

}
