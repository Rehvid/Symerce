import React from 'react';
import SelectFilter from '@admin/common/components/tableList/filters/SelectFilter';
import { TableFilters } from '@admin/common/interfaces/TableFilters';

interface ActiveFilterProps<T extends TableFilters> {
    filters: T;
    setFilters: React.Dispatch<React.SetStateAction<T>>;
}

const ActiveFilter = <T extends TableFilters>({ filters, setFilters }: ActiveFilterProps<T>): React.ReactElement => (
    <SelectFilter
        filters={filters}
        setFilters={setFilters}
        nameFilter="isActive"
        options={[
            { label: 'Aktywny', value: true },
            { label: 'Nieaktywny', value: false },
        ]}
        label="Aktywny"
    />
);

export default ActiveFilter;
