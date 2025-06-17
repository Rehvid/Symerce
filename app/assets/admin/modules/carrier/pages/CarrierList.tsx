import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowImageWithText from '@admin/common/components/tableList/tableRow/TableRowImageWithText';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableActions from '@admin/common/components/tableList/TableActions';
import { TableColumn } from '@admin/common/types/tableColumn';
import { CarrierTableFilters } from '@admin/modules/carrier/interfaces/CarrierTableFilters';
import { CarrierListItem } from '@admin/modules/carrier/interfaces/CarrierListItem';
import CarrierIcon from '@/images/icons/carrier.svg';
import TableRowMoney from '@admin/common/components/tableList/tableRow/TableRowMoney';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';
import RangeFilter from '@admin/common/components/tableList/filters/RangeFilter';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';
import useDraggable from '@admin/common/hooks/list/useDraggable';

const CarrierList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
    const [filters, setFilters] = useState<CarrierTableFilters>(
        filterEmptyValues({
            ...defaultFilters,
            search: getCurrentParam('search', (value) => String(value)),
            isActive: getCurrentParam('isActive', (value) => Boolean(value)),
            feeFrom: getCurrentParam('feeFrom', (value) => Number(value)),
            feeTo: getCurrentParam('feeTo', (value) => Number(value)),
        }) as CarrierTableFilters,
    );
    const { draggableCallback } = useDraggable('admin/position/carrier');

    const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<
        CarrierListItem,
        CarrierTableFilters
    >({
        endpoint: 'admin/carriers',
        filters,
        setFilters,
        defaultSort,
    });

    const rowData = items.map((item: CarrierListItem) => [
        <TableRowId id={item.id} />,
        <TableRowImageWithText
            imagePath={item.imagePath}
            text={item.name}
            defaultIcon={<CarrierIcon className="text-primary mx-auto w-[24px] h-[24px]" />}
        />,

        <TableRowActive isActive={item.isActive} />,
        <TableRowMoney amount={item.fee?.amount} symbol={item.fee?.symbol} />,
        <TableActions id={item.id} onDelete={() => removeItem(`admin/carriers/${item.id}`)} />,
    ]);

    const columns: TableColumn[] = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'isActive', label: 'Aktywny', sortable: true },
        { orderBy: 'fee', label: 'Opłata', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    return (
        <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
            <TableToolbar>
                <TableToolbarActions title="Lista przewoźników" totalItems={pagination?.totalItems} />
                <TableToolbarFilters
                    sort={sort}
                    setSort={setSort}
                    filters={filters}
                    setFilters={setFilters}
                    defaultFilters={defaultFilters}
                >
                    <ActiveFilter setFilters={setFilters} filters={filters} />
                    <RangeFilter filters={filters} setFilters={setFilters} label="Opłata" nameFilter="fee" />
                </TableToolbarFilters>
            </TableToolbar>
            <TableWrapper isLoading={isLoading}>
                <TableHead sort={sort} setSort={setSort} columns={columns} />
                <TableBody
                    data={rowData}
                    filters={filters}
                    pagination={pagination as Pagination}
                    useDraggable={true}
                    draggableCallback={draggableCallback}
                />
            </TableWrapper>
            <TablePagination filters={filters} setFilters={setFilters} pagination={pagination as Pagination} />
        </TableWithLoadingSkeleton>
    );
};

export default CarrierList;
