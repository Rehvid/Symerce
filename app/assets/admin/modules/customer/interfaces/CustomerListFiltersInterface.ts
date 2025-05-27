import { ListDefaultFiltersInterface } from '@admin/shared/interfaces/ListDefaultFiltersInterface';

export interface CustomerListFiltersInterface extends ListDefaultFiltersInterface {
  isActive: boolean,
}
