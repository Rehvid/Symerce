import SearchIcon from '../../../../images/shared/search.svg';

function SearchFilter({ filters, setFilters }) {
    const onBlur = e => {
        setFilters({
            ...filters,
            search: e.target.value,
        });
    };

    return (
        <div className="relative">
            <button className="absolute -translate-y-1/2 left-4 top-1/2 cursor-pointer">
                <SearchIcon className="text-gray-500" />
            </button>
            <input
                type="text"
                placeholder="Search..."
                className="h-[42px] w-full rounded-full border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs transition-all placeholder:text-gray-400 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-4 focus:ring-primary-light"
                onBlur={onBlur}
                defaultValue={filters?.search || ''}
            />
        </div>
    );
}

export default SearchFilter;
