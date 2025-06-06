import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';

export interface ProfilePersonalFormData extends FormDataInterface {
    email: string;
    firstname: string;
    surname: string;
    id: number | string;
}
