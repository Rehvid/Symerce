import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface CurrencyTableFilters extends TableFilters {
  roundingPrecisionFrom?: number;
  roundingPrecisionTo?: number;
  search?: string;
}
