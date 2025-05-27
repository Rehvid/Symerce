import { ListDefaultFiltersInterface } from '@admin/shared/interfaces/ListDefaultFiltersInterface';

export interface CountryListFiltersInterface extends ListDefaultFiltersInterface {
  id: number,
  name: string,
  code: string,
  isActive: boolean,
}
