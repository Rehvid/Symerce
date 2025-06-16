import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

interface Config {
    key: string;
    value: string;
}

export interface PaymentMethodFormData extends FormDataInterface {
    id?: number | null;
    name: string;
    isActive: boolean;
    code: string;
    fee: string;
    isRequireWebhook: boolean;
    config: Config[];
    thumbnail?: UploadFile;
}
