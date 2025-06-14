import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { AddressDelivery } from '@admin/common/interfaces/AddressDelivery';
import { AddressInvoice } from '@admin/common/interfaces/AddressInvoice';

export interface CustomerFormData extends FormDataInterface, AddressDelivery, AddressInvoice {
    id?: number | null;
    firstname: string;
    surname: string;
    email: string;
    phone?: string | null;
    isActive: boolean;
    isDelivery: boolean;
    isInvoice: boolean;
    password?: string | null;
    passwordConfirmation?: string | null;
}
