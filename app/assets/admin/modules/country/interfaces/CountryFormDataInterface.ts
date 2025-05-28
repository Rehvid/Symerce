import { FormDataInterface } from '@admin/shared/interfaces/FormDataInterface';

export interface CountryFormDataInterface extends FormDataInterface {
  id?: string|number,
  name?: string,
  code?: string,
  isActive: boolean,
}
