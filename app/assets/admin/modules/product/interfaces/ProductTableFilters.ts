import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface ProductTableFilters extends TableFilters {
  isActive?: boolean,
  regularPriceFrom? : number,
  regularPriceTo?: number,
  quantity?: number
  search?: string,
}
