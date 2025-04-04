import SearchIcon from '../../../../images/icons/search.svg';
import AppInput from '@/admin/components/form/AppInput';

const SearchFilter = ({ filters, setFilters }) => {
    const onBlur = (e) => {
        setFilters({
            ...filters,
            search: e.target.value,
        });
    };

    return (
        <div className="relative">
            <AppInput
                label="Szukaj"
                onBlur={onBlur}
                type="search"
                defaultValue={filters?.search || ''}
                icon={<SearchIcon className="text-gray-500" />}
            />
        </div>
    );
};

export default SearchFilter;
