import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface AttributeValueTableFilters extends TableFilters {
    isActive?: boolean;
    search?: string;
}
