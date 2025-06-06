import { ListDefaultFiltersInterface } from '@admin/common/interfaces/ListDefaultFiltersInterface';

export interface CountryListFiltersInterface extends ListDefaultFiltersInterface {
  id: number,
  name: string,
  code: string,
  isActive: boolean,
}
