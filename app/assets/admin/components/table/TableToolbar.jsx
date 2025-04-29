import SearchFilter from './Filters/SearchFilter';
import AppButton from '@/admin/components/common/AppButton';
import { isOnlyPaginationInDataTable } from '@/admin/utils/helper';

const TableToolbar = ({ setSort, sort, filters, setFilters, additionalFilters = [], defaultFilters = {} }) => {
    return (
        <div className="flex items-center gap-4 justify-between">
            <div className="flex gap-2 items-center">
                <SearchFilter filters={filters} setFilters={setFilters} />
                {!isOnlyPaginationInDataTable(filters) && (
                    <AppButton
                        onClick={() => setFilters(defaultFilters)}
                        variant="secondary"
                        additionalClasses="px-2 py-1.5"
                    >
                        Resetuj Filtrowanie
                    </AppButton>
                )}
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
                    <ul className="flex items-center justify-center gap-5">
                        {additionalFilters.map((filterComponent, index) => (
                            <li key={index}>{filterComponent}</li>
                        ))}
                    </ul>
                )}
            </div>
        </div>
    );
};

export default TableToolbar;
