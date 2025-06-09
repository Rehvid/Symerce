import React, { useState, useEffect } from 'react';
import ReactSelect from '@admin/common/components/form/reactSelect/ReactSelect';
import { TableFilters } from '@admin/common/interfaces/TableFilters';
import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import { SelectOption } from '@admin/common/types/selectOption';



interface SelectFilterProps<T extends TableFilters> {
    filters: T;
    setFilters: React.Dispatch<React.SetStateAction<T>>;
    nameFilter: keyof T & string;
    options: SelectOption[];
    label?: string;
    isMulti?: boolean;
}

const SelectFilter = <T extends TableFilters,>({
   filters,
   setFilters,
   nameFilter,
   options,
   label = '',
   isMulti = false,
}: SelectFilterProps<T>): React.ReactElement => {

    const getCurrentValue = () => {
        const currentValue = filters[nameFilter];

        if (currentValue === undefined || currentValue === null) {
            return null;
        }

        if (isMulti && Array.isArray(currentValue)) {
            return options.filter(option => currentValue.includes(option.value));
        }

        return options.find(option => option.value === currentValue) || null;
    };

    const [selectedOption, setSelectedOption] = useState<SelectOption | SelectOption[] | null>(getCurrentValue());

    useEffect(() => {
        setSelectedOption(getCurrentValue());
    }, [filters[nameFilter]]);

    const handleChange = (selected: SelectOption | SelectOption[] | null) => {
        setSelectedOption(selected);

        if (selected === null) {
            const { [nameFilter]: _, ...rest } = filters;
            setFilters({ ...rest, page: 1 } as T);
            return;
        }

        if (isMulti && Array.isArray(selected)) {
            const values = selected.map(option => option.value);
            setFilters({
                ...filters,
                [nameFilter]: values,
                page: 1,
            } as T);
        } else if (!isMulti && selected) {
            setFilters({
                ...filters,
                [nameFilter]: (selected as SelectOption).value,
                page: 1,
            } as T);
        }
    };

    return (
        <div className="flex flex-col">
            {label && (
                <Heading level={HeadingLevel.H4} additionalClassNames="mb-2">
                    {label}
                </Heading>
            )}
            <ReactSelect
                options={options}
                value={selectedOption}
                onChange={handleChange}
                isMulti={isMulti}
                hasError={false}
                errorMessage=""
            />
        </div>
    );
};

export default SelectFilter;
