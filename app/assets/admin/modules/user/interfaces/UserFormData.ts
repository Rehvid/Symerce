import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { AdminRole } from '@admin/common/enums/adminRole';
import { UploadFile } from '@admin/common/interfaces/UploadFile';
import { Password } from '@admin/common/components/form/fields/PasswordFields';
import { EmailField } from '@admin/common/components/form/fields/Email';
import { FirstnameField } from '@admin/common/components/form/fields/Firstname';
import { SurnameField } from '@admin/common/components/form/fields/Surname';

export interface UserFormData extends FormDataInterface, Password, EmailField, FirstnameField, SurnameField {
    id?: number | null;
    isActive: boolean;
    roles: AdminRole[];
    avatar: UploadFile | null;
}
