import { FormDataInterface } from '@admin/shared/interfaces/FormDataInterface';

export interface ProfileSecurityFormData extends FormDataInterface {
    password: string;
    passwordConfirmation: string;
}
