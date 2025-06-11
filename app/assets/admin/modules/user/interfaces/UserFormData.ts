import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { AdminRole } from '@admin/common/enums/adminRole';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

export interface UserFormData extends FormDataInterface {
    id?: number | null;
    firstname: string;
    surname: string;
    email: string;
    isActive: boolean;
    roles: AdminRole[];
    avatar: UploadFile | null;
    password?: string;
    passwordConfirmation?: string;
}
