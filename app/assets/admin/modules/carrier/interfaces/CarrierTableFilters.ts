import { TableFilters } from '@admin/common/interfaces/TableFilters';

export interface CarrierTableFilters extends TableFilters {
    search?: string;
    isActive?: boolean;
    feeFrom?: number;
    feeTo?: number;
}
