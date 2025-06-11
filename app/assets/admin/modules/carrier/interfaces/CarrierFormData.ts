import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

interface ExternalData {
    key: string,
    value: string,
}

export interface CarrierFormData extends FormDataInterface {
    name: string,
    isActive: boolean,
    fee: string,
    isExternal: string,
    externalData: ExternalData[],
    thumbnail: UploadFile | null,
}
