import SearchIcon from '../../../../images/icons/search.svg';
import Input from '@/admin/components/form/controls/Input';
import { useCallback } from 'react';

const SearchFilter = ({ filters, setFilters }) => {
    const onChange = useCallback(
        (e) => {
            const value = e.target.value.trim();

            if (value === '' && filters?.search) {
                // eslint-disable-next-line no-unused-vars
                const { search, ...rest } = filters;
                setFilters(rest);
            } else if (value !== '') {
                setFilters((prev) => ({
                    ...prev,
                    search: value,
                }));
            }
        },
        [filters, setFilters],
    );

    return (
        <Input
            onChange={onChange}
            type="search"
            value={filters?.search || ''}
            icon={<SearchIcon className="text-gray-500" />}
            placeholder="Szukaj"
            id="search"
            containerClassName="w-full"
        />
    );
};

export default SearchFilter;
