import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';

export interface WarehouseFormData extends FormDataInterface {
    name: string;
    isActive: boolean;
    country: number | null;
    street: string;
    city: string;
    postalCode: string;
    description?: string;
}
