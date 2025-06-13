import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface CustomerTableFilters extends TableFilters {
    isActive: boolean;
    search?: string;
}
