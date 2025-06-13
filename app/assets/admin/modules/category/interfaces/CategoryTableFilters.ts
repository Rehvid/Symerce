import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface CategoryTableFilters extends TableFilters {
    isActive: boolean,
    search?: string,
}
