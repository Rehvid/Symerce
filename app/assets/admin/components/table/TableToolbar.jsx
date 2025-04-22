import SearchFilter from './Filters/SearchFilter';

const TableToolbar = ({ filters, setFilters, additionalFilters = [] }) => {
    return (
        <div className="flex items-center gap-4 justify-between">
            <div className="flex gap-2 items-center">
                <SearchFilter filters={filters} setFilters={setFilters} />
                {additionalFilters && additionalFilters.length > 0 && (
                    <ul className="flex flex-col gap-5">
                        {additionalFilters.map((FilterComponent, index) => (
                            <li key={index}>
                                <FilterComponent setFilters={setFilters} filters={filters} />
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </div>
    );
};

export default TableToolbar;
