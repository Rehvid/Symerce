import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';

export interface CountryFormData extends FormDataInterface {
  id?: number | null,
  name?: string,
  code?: string,
  isActive: boolean,
}
