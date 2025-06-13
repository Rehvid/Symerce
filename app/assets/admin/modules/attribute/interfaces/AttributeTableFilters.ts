import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface AttributeTableFilters extends TableFilters {
    isActive?: boolean,
    search?: string,
}
