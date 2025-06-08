import React  from 'react';
import SearchFilter from '@admin/common/components/tableList/filters/SearchFilter';
import DrawerTrigger from '@admin/common/components/drawer/DrawerTrigger';
import Button, { ButtonVariant } from '@admin/common/components/Button';
import FilterIcon from '@/images/icons/filter.svg';
import SortResetIcon from '@/images/icons/sort-reset.svg';
import DrawerContent from '@admin/common/components/drawer/DrawerContent';
import { PositionType } from '@admin/common/enums/positionType';
import DrawerHeader from '@admin/common/components/drawer/DrawerHeader';
import { isOnlyPaginationInDataTable } from '@admin/common/utils/helper';
import FilterResetIcon from '@/images/icons/filter-reset.svg';
import { TableFilters } from '@admin/common/interfaces/TableFilters';
import { Sort } from '@admin/common/interfaces/Sort';

interface TableToolbarFilters<T extends TableFilters> {
    sort: Sort;
    setSort: React.Dispatch<React.SetStateAction<Sort>>;
    filters: T;
    setFilters: React.Dispatch<React.SetStateAction<T>>;
    defaultFilters: TableFilters;
    children: React.ReactNode;
}

const TableToolbarFilters= <T extends TableFilters,> ({
    setSort,
    sort,
    filters,
    setFilters,
    defaultFilters = { limit: 10, page: 1 },
    children,
}: TableToolbarFilters<T>) => {
    const openFilters = (children: React.ReactNode) => (
        <DrawerContent position={PositionType.RIGHT} drawerId="filters">
            <DrawerHeader>
                <div className="flex gap-2">
                    <FilterIcon className="w-[24px] h-[24px] text-gray-400 " />
                    <span className="font-medium">Filtry</span>
                </div>
            </DrawerHeader>
            <div className="flex flex-col gap-[1.5rem] p-4">{children}</div>
        </DrawerContent>
    );

    const resetFilters = () => {
        if (isOnlyPaginationInDataTable(filters)) {
            return null;
        }

        const onClickFilters = () => {
            const filtersToReset = { ...defaultFilters };
            setFilters(filtersToReset as T);
        };

        return (
            <Button
                onClick={onClickFilters}
                variant={ButtonVariant.Secondary}
                additionalClasses="px-4 py-1.5 flex gap-2"
            >
                <FilterResetIcon className="w-[24px] h-[24px]" />
                Resetuj Filtrowanie
            </Button>
        );
    };

    return (
        <>
            <div className="sm:flex sm:items-center gap-4 sm:justify-between">
                <SearchFilter filters={filters} setFilters={setFilters} />
                {children && (
                    <>
                        <DrawerTrigger drawerId="filters">
                            <Button
                                variant={ButtonVariant.Secondary}
                                additionalClasses="h-[46px] px-5 flex gap-2 mt-4 sm:mt-0 w-full sm:w-auto justify-center items-center"
                            >
                                <FilterIcon />
                                Filtry
                            </Button>
                        </DrawerTrigger>

                        {openFilters(children)}
                    </>
                )}
            </div>
            <div className="grid grid-cols-[repeat(auto-fit,_minmax(200px,_1fr))] sm:flex gap-4 mt-4">
                {resetFilters()}
                {sort && sort.orderBy !== null && (
                    <Button
                        onClick={() => setSort({ orderBy: null, direction: null })}
                        variant={ButtonVariant.Secondary}
                        additionalClasses="px-4 py-1.5 flex gap-2"
                    >
                        <SortResetIcon className="w-[24px] h-[24px]" />
                        Resetuj sortowanie
                    </Button>
                )}
            </div>
        </>
    );
};

export default TableToolbarFilters;
