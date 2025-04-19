import SearchIcon from '../../../../images/icons/search.svg';
import Input from '@/admin/components/form/controls/Input';

const SearchFilter = ({ filters, setFilters }) => {
    const onBlur = (e) => {
        setFilters({
            ...filters,
            search: e.target.value,
        });
    };

    return (
        <div className="relative">
            <Input
                onBlur={onBlur}
                type="search"
                defaultValue={filters?.search || ''}
                icon={<SearchIcon className="text-gray-500" />}
            />
        </div>
    );
};

export default SearchFilter;
