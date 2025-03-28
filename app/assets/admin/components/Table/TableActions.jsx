import Dropdown from '../../../shared/components/Dropdown/Dropdown';
import DropdownButton from '../../../shared/components/Dropdown/DropdownButton';
import AppButton from '../Common/AppButton';
import FilterIcon from '../../../images/shared/filter.svg';
import DropdownContent from '../../../shared/components/Dropdown/DropdownContent';
import SearchFilter from './Filters/SearchFilter';

const TableActions = ({ filters, setFilters, header, actions, additionalFilters = [] }) => {
    return (
        <div className="flex items-center gap-4 justify-between">
            {header}

            <div className="flex gap-2 items-center">
                <SearchFilter filters={filters} setFilters={setFilters} />
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
                {actions}
            </div>
        </div>
    );
}

export default TableActions;
