import SearchIcon from '../../../../../images/icons/search.svg';
import React, { useState, useEffect, ChangeEvent } from 'react';
import { TableFilters } from '@admin/common/interfaces/TableFilters';
import InputField from '@admin/common/components/form/input/InputField';

interface SearchFilterProps<T extends TableFilters> {
    filters: T;
    setFilters: React.Dispatch<React.SetStateAction<T>>;
}

const SearchFilter = <T extends TableFilters>({ filters, setFilters }: SearchFilterProps<T>) => {
    const [inputValue, setInputValue] = useState(filters?.search || '');

    useEffect(() => {
        setInputValue(filters?.search || '');
    }, [filters]);

    const onInputChange = (e: ChangeEvent<HTMLInputElement>) => {
        setInputValue(e.target.value);
    };

    const onSearchClick = () => {
        const value = inputValue.trim();

        if (value === '' && filters?.search) {
            const { search, ...rest } = filters;
            setFilters(rest as T);
        } else if (value !== '') {
            setFilters((prev) => ({
                ...prev,
                search: value,
            }));
        }
    };

    return (
        <InputField
            onChange={onInputChange}
            type="text"
            value={inputValue}
            icon={<SearchIcon className="text-gray-500 w-5 h-5 cursor-pointer" onClick={onSearchClick} />}
            placeholder="Szukaj"
            containerClasses="w-full"
            id="search"
            onKeyDown={(e) => {
                if (e.key === 'Enter') {
                    onSearchClick();
                }
            }}
        />
    );
};

export default SearchFilter;
