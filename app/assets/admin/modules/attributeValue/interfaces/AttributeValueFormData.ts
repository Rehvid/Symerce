import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';

export interface AttributeValueFormData extends FormDataInterface {
    value: string;
    attributeId: number | null;
}
