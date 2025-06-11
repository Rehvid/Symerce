import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

export interface BrandFormData extends FormDataInterface {
    name: string;
    isActive: boolean;
    thumbnail?: UploadFile;
}
