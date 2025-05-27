import { FormDataInterface } from '@admin/shared/interfaces/FormDataInterface';

export interface CountryFormDataInterface extends FormDataInterface {
  name?: string,
  code?: string,
  isActive: boolean,
}
