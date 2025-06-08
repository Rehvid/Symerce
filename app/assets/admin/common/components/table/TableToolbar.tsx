import SearchFilter from '../tableList/filters/SearchFilter';
import Button, { ButtonVariant } from '@admin/common/components/Button';
import { isOnlyPaginationInDataTable } from '@admin/common/utils/helper';
import FilterIcon from '@/images/icons/filter.svg';
import FilterResetIcon from '@/images/icons/filter-reset.svg';
import SortResetIcon from '@/images/icons/sort-reset.svg';
import { useModal } from '@admin/common/context/ModalContext';
import ModalHeader from '@admin/common/components/modal/ModalHeader';
import ModalBody from '@admin/common/components/form/ModalBody';
import { PositionType } from '@admin/common/enums/positionType';
import React, { ReactNode } from 'react';
import DrawerTrigger from '@admin/common/components/drawer/DrawerTrigger';
import DrawerContent from '@admin/common/components/drawer/DrawerContent';
import DrawerHeader from '@admin/common/components/drawer/DrawerHeader';

interface SortState {
    orderBy: string | null;
    direction: 'asc' | 'desc' | null;
}

interface TableToolbarProps {
    setSort: (sort: SortState) => void;
    sort: SortState;
    filters: Record<string, any>;
    setFilters: (filters: Record<string, any>) => void;
    additionalToolbarContent?: ReactNode;
    additionalFilters?: ReactNode[];
    defaultFilters?: Record<string, any>;
}

const TableToolbar: React.FC<TableToolbarProps> = ({
    setSort,
    sort,
    filters,
    setFilters,
    additionalToolbarContent = '',
    additionalFilters = [],
    defaultFilters = {},
}) => {
    const { openModal } = useModal();

    const filtersContent = () => {
        if (!additionalFilters || additionalFilters.length === 0) {
            return null;
        }

        return additionalFilters.map((filterComponent, index) => <div key={index}>{filterComponent}</div>);
    };

    const renderModal = () => (
        <>
            <ModalHeader title="Filtry" />
            <ModalBody>
                <div className="flex flex-col gap-[2rem] justify-between lg:w-[500px]">{filtersContent()}</div>
            </ModalBody>
        </>
    );


    const openFilters = () => (
        <DrawerContent position={PositionType.RIGHT}>
            <DrawerHeader>
                <div className="flex gap-2">
                    <FilterIcon className="w-[24px] h-[24px] text-gray-400 " />
                    <span className="font-medium">Filtry</span>
                </div>
            </DrawerHeader>
            <div className="flex flex-col gap-[1.5rem] p-4">{filtersContent()}</div>
        </DrawerContent>
    );

    const resetFilters = () => {
        if (isOnlyPaginationInDataTable(filters)) {
            return null;
        }

        const onClickFilters = () => {
            const filtersToReset = {
                ...(defaultFilters?.page && { page: defaultFilters.page }),
                ...(defaultFilters?.limit && { limit: defaultFilters.limit }),
            };
            setFilters(filtersToReset);
        };

        return (
            <Button onClick={onClickFilters} variant="secondary" additionalClasses="px-4 py-1.5 flex gap-2">
                <FilterResetIcon className="w-[24px] h-[24px]" />
                Resetuj Filtrowanie
            </Button>
        );
    };

    return (
        <>
            {additionalToolbarContent && <div className="mb-[2rem]">{additionalToolbarContent}</div>}
            <div className="sm:flex sm:items-center gap-4 sm:justify-between">
                <SearchFilter filters={filters} setFilters={setFilters} />
                {additionalFilters && additionalFilters.length > 0 && (
                    <>
                        <DrawerTrigger>
                            <Button
                                variant={ButtonVariant.Secondary}
                                additionalClasses="h-[46px] px-5 flex gap-2 mt-4 sm:mt-0 w-full sm:w-auto justify-center items-center"
                            >
                                <FilterIcon className="w-[24px] h-[24px]" />
                                Filtry
                            </Button>
                        </DrawerTrigger>
                        {openFilters()}
                    </>
                )}
            </div>
            <div className="grid grid-cols-[repeat(auto-fit,_minmax(200px,_1fr))] sm:flex gap-4 mt-4">
                {resetFilters()}
                {sort && sort.orderBy !== null && (
                    <Button
                        onClick={() => setSort({ orderBy: null, direction: null })}
                        variant="secondary"
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

export default TableToolbar;
