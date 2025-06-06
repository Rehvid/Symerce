import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';

export interface ProfileSecurityFormData extends FormDataInterface {
    password: string;
    passwordConfirmation: string;
}
