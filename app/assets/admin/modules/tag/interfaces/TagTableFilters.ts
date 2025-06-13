import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface TagListFiltersInterface extends TableFilters {
    isActive?: boolean,
    search?: string,
}
