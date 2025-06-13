import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface CountryTableFilters extends TableFilters {
  isActive: boolean,
  search?: string,
}
