import { FormDataInterface } from '@admin/shared/interfaces/FormDataInterface';

export interface SettingFormDataInterface extends FormDataInterface {
  name: string,
  isActive: boolean,
  settingField: {
    type: string,
    inputType: string,
    value: any,
    availableOptions?: {
      label: string,
      value: string|number
    }[]
  }
}
