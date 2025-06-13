import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';

export interface SettingField {
    type: string;
    inputType: string;
    value: any;
    availableOptions?: {
        label: string;
        value: string | number;
    }[];
}

export interface SettingFormData extends FormDataInterface {
    name: string;
    isActive: boolean;
    settingField: SettingField;
}
