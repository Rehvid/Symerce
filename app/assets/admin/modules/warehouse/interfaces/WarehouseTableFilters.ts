import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface WarehouseTableFilters extends TableFilters {
    search?: string,
    isActive?: boolean,
}
