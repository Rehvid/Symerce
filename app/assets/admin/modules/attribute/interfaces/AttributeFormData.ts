import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';

export interface AttributeFormData extends FormDataInterface {
    name: string;
    type: string;
    isActive: boolean;
}
