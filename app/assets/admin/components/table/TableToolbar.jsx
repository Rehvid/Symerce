import SearchFilter from './Filters/SearchFilter';
import AppButton from '@/admin/components/common/AppButton';
import { isOnlyPaginationInDataTable } from '@/admin/utils/helper';
import FilterIcon from '@/images/icons/filter.svg';
import FilterResetIcon from '@/images/icons/filter-reset.svg';
import SortResetIcon from '@/images/icons/sort-reset.svg';
import { useModal } from '@/admin/hooks/useModal';
import { POSITION_TYPES } from '@/admin/constants/positionConstants';
import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';

const TableToolbar = ({
    setSort,
    sort,
    filters,
    setFilters,
    additionalToolbarContent = '',
    additionalFilters = [],
    defaultFilters = {},
}) => {
    const { openModal } = useModal();

    const renderModal = () => (
        <>
            <ModalHeader title="Filtry" />
            <ModalBody>
                <div className="flex flex-col gap-[2rem] justify-between lg:w-[500px]">{filtersContent()}</div>
            </ModalBody>
        </>
    );

    const openFilters = () => {
        openModal(renderModal(), POSITION_TYPES.RIGHT);
    };

    const filtersContent = () => {
        if (additionalFilters && additionalFilters.length === 0) {
            return null;
        }
        return additionalFilters.map((filterComponent, index) => <div key={index}>{filterComponent}</div>);
    };

    const resetFilters = () => {
        if (isOnlyPaginationInDataTable(filters)) {
            return null;
        }

        const onClickFilters = () => {
            const filtersToReset = { ...defaultFilters?.page, ...defaultFilters?.limit };
            setFilters(filtersToReset);
        };

        return (
            <AppButton onClick={() => onClickFilters()} variant="secondary" additionalClasses="px-4 py-1.5 flex gap-2">
                <FilterResetIcon className="w-[24px] h-[24px]" />
                Resetuj Filtrowanie
            </AppButton>
        );
    };

    return (
        <>
            {additionalToolbarContent && <div className="mb-[2rem]">{additionalToolbarContent}</div>}
            <div className="sm:flex sm:items-center gap-4 sm:justify-between">
                <SearchFilter filters={filters} setFilters={setFilters} />
                {additionalFilters && additionalFilters.length > 0 && (
                    <AppButton
                        variant="secondary"
                        additionalClasses="h-[46px] px-5 flex gap-2 mt-4 sm:mt-0 w-full sm:w-auto justify-center items-center"
                        onClick={() => openFilters()}
                    >
                        <FilterIcon className="w-[24px] h-[24px]" />
                        Filtry
                    </AppButton>
                )}
            </div>
            <div className="grid grid-cols-[repeat(auto-fit,_minmax(200px,_1fr))] sm:flex gap-4 mt-4">
                {resetFilters()}
                {sort && sort.orderBy !== null && (
                    <AppButton
                        onClick={() => setSort({ orderBy: null, direction: null })}
                        variant="secondary"
                        additionalClasses="px-4 py-1.5 flex gap-2"
                    >
                        <SortResetIcon  className="w-[24px] h-[24px]" />
                        Resetuj sortowanie
                    </AppButton>
                )}
            </div>
        </>
    );
};

export default TableToolbar;
