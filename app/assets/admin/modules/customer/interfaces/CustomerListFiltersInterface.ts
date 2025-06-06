import { ListDefaultFiltersInterface } from '@admin/common/interfaces/ListDefaultFiltersInterface';

export interface CustomerListFiltersInterface extends ListDefaultFiltersInterface {
  isActive: boolean,
}
