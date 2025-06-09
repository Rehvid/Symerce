import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { UploadFileInterface } from '@admin/common/interfaces/UploadFileInterface';

export interface BrandFormData extends FormDataInterface {
    name: string;
    isActive: boolean;
    thumbnail?: UploadFileInterface;
}
