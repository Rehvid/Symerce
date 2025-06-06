import React from 'react';
import SelectFilter from '@admin/common/components/table/partials/filters/SelectFilter';

interface FiltersType {
    [key: string]: any;
}

interface ActiveFilterProps {
    filters: FiltersType;
    setFilters: (filters: FiltersType) => void;
}

const ActiveFilter: React.FC<ActiveFilterProps> = ({ filters, setFilters }) => (
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
