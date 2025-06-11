import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

export interface CategoryFormData extends FormDataInterface {
    id?: number | null
    name: string,
    isActive: boolean,
    description: string,
    slug?: string,
    metaTitle? :string,
    metaDescription?: string,
    parentCategoryId?: number,
    thumbnail: UploadFile | null,
}
