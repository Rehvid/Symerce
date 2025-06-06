import { ListDefaultFiltersInterface } from '@admin/common/interfaces/ListDefaultFiltersInterface';

export interface ProductListFiltersInterface extends ListDefaultFiltersInterface {
  isActive?: boolean,
  regularPriceFrom? : number,
  regularPriceTo?: number,
  quantity?: number
}
