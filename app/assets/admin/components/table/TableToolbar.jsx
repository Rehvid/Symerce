import SearchFilter from './Filters/SearchFilter';
import AppButton from '@/admin/components/common/AppButton';

const TableToolbar = ({ setSort, sort, filters, setFilters, additionalFilters = [],  }) => {
    return (
        <div className="flex items-center gap-4 justify-between">
            <div className="flex gap-2 items-center">
                <SearchFilter filters={filters} setFilters={setFilters} />
              {sort && sort.orderBy !== null && (
                <AppButton
                  onClick={() => setSort({ orderBy: null, direction: null })}
                  variant="secondary"
                  additionalClasses="px-2 py-1.5"
                >
                  Resetuj sortowanie
                </AppButton>
              )}
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
