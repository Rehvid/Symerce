import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { UploadFile } from '@admin/common/interfaces/UploadFile';
import { MetaFieldsInterface } from '@admin/common/components/form/fields/formGroup/MetaFields';
import { SlugInterface } from '@admin/common/components/form/fields/formGroup/Slug';

export interface CategoryFormData extends FormDataInterface, MetaFieldsInterface, SlugInterface {
    id?: number | null;
    name: string;
    isActive: boolean;
    description: string;
    parentCategoryId?: number;
    thumbnail: UploadFile | null;
}
