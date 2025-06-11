import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';


export interface CustomerFormData extends FormDataInterface {
    id?: number | null;
    firstname: string;
    surname : string;
    email: string;
    phone?: string | null;
    isActive: boolean;
    isDelivery: boolean;
    isInvoice: boolean;
    city?: string | null;
    country?: number | null;
    postalCode?: string | null;
    street?: string | null;
    deliveryInstructions?: string | null;
    invoiceCity?: string | null;
    invoiceCountry?: number | null;
    invoicePostalCode?: string | null;
    invoiceStreet?: string | null;
    invoiceCompanyName?: string | null;
    invoiceCompanyTaxId?: string | null;
    password?: string | null;
    passwordConfirmation?: string | null;
}
