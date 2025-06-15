import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { AddressDelivery } from '@admin/common/interfaces/AddressDelivery';

export interface WarehouseFormData extends FormDataInterface, AddressDelivery {
    name: string;
    isActive: boolean;
    description?: string;
}
