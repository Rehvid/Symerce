import SearchIcon from '../../../../images/shared/search.svg';
import AppInput from "@/shared/components/Form/AppInput";

const SearchFilter = ({ filters, setFilters }) => {
    const onBlur = e => {
        setFilters({
            ...filters,
            search: e.target.value,
        });
    };

    return (
        <div className="relative">
            <AppInput
                label={"Szukaj"}
                onBlur={onBlur}
                type='search'
                value={filters?.search || ''}
                icon={<SearchIcon className="text-gray-500" />}
            />
        </div>
    );
};

export default SearchFilter;
