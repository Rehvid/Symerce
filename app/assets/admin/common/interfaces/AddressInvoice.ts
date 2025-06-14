export interface AddressInvoice {
    invoiceCity: string;
    invoiceCountryId: number;
    invoicePostalCode: string;
    invoiceStreet: string;
    invoiceCompanyName?: string | null;
    invoiceCompanyTaxId?: string | null;
}
