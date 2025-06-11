import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface CountryTableFilters extends TableFilters {
  id: number,
  name: string,
  code: string,
  isActive: boolean,
}
