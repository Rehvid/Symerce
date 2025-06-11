import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';

export interface TagFormData extends FormDataInterface {
    name: string;
    backgroundColor: string;
    textColor: string;
    isActive: boolean;
}
