import React, { useState, useEffect } from 'react';
import ReactSelect from '@admin/common/components/form/reactSelect/ReactSelect';
import { TableFilters } from '@admin/common/interfaces/TableFilters';
import { SelectOption } from '@admin/common/types/selectOption';

export const PAGINATION_FILTER_DEFAULT_OPTION = 10;

interface PaginationFilterProps<T extends TableFilters> {
    filters: T;
    setFilters: React.Dispatch<React.SetStateAction<T>>;
    overrideDefaultOptions?: boolean;
    options?: SelectOption[];
}

const PaginationFilter = <T extends TableFilters>({
    filters,
    setFilters,
    overrideDefaultOptions = false,
    options = [],
}: PaginationFilterProps<T>): React.ReactElement => {
    const defaultOptions: SelectOption[] = [
        { value: 10, label: 10 },
        { value: 25, label: 25 },
        { value: 50, label: 50 },
        { value: 100, label: 100 },
        { value: -1, label: 'Wszystkie' },
    ];

    const activeOptions = overrideDefaultOptions ? options : defaultOptions;

    const getCurrentValue = () => {
        const currentLimit = Number(filters.limit) || PAGINATION_FILTER_DEFAULT_OPTION;
        return activeOptions.find((option) => option.value === currentLimit) || null;
    };

    const [selectedOption, setSelectedOption] = useState<SelectOption | null>(getCurrentValue());

    useEffect(() => {
        setSelectedOption(getCurrentValue());
    }, [filters.limit]);

    const handleChange = (selected: SelectOption | null) => {
        setSelectedOption(selected);

        if (selected === null) {
            setFilters({
                ...filters,
                limit: PAGINATION_FILTER_DEFAULT_OPTION,
                page: 1,
            } as T);
            return;
        }

        setFilters({
            ...filters,
            limit: selected,
            page: 1,
        } as T);
    };

    return (
        <div className="md:max-w-48 w-full">
            <ReactSelect
                options={activeOptions}
                value={selectedOption}
                onChange={handleChange}
                isMulti={false}
                hasError={false}
                errorMessage=""
                menuPlacement="top"
            />
        </div>
    );
};

export default PaginationFilter;
