import FilterIcon from '@/images/icons/filter.svg';
import SearchFilter from './Filters/SearchFilter';
import DropdownButton from '@/admin/components/dropdown/DropdownButton';
import Dropdown from '@/admin/components/dropdown/Dropdown';
import DropdownContent from '@/admin/components/dropdown/DropdownContent';
import AppButton from '@/admin/components/common/AppButton';

const TableToolbar = ({ filters, setFilters, titleSection, actionButtons, additionalFilters = [] }) => {
    return (
        <div className="flex items-center gap-4 justify-between">
            {titleSection}

            <div className="flex gap-2 items-center">
                <SearchFilter filters={filters} setFilters={setFilters} />
                {additionalFilters && additionalFilters.length > 0 && (
                    <Dropdown>
                        <DropdownButton>
                            <AppButton variant="secondary" additionalClasses="flex gap-3 px-5 py-2.5 ">
                                <FilterIcon className={'text-gray-500'} />
                                Filter
                            </AppButton>
                        </DropdownButton>
                        <DropdownContent containerClasses="w-[300px] mt-2">
                            <ul className="flex flex-col gap-5">
                                {additionalFilters.map((FilterComponent, index) => (
                                    <li key={index}>
                                        <FilterComponent setFilters={setFilters} filters={filters} />
                                    </li>
                                ))}
                            </ul>
                        </DropdownContent>
                    </Dropdown>
                )}
                {actionButtons}
            </div>
        </div>
    );
};

export default TableToolbar;
