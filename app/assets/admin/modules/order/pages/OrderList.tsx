import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { useListData } from '@admin/common/hooks/list/useListData';
import { OrderListItem } from '@admin/modules/order/interfaces/OrderListItem';
import React, { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { OrderTableFilters } from '@admin/modules/order/interfaces/OrderTableFilters';
import { TableColumn } from '@admin/common/types/tableColumn';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowMoney from '@admin/common/components/tableList/tableRow/TableRowMoney';
import TableRowEditAction from '@admin/common/components/tableList/tableRow/TableRowEditAction';
import TableRowDetailAction from '@admin/common/components/tableList/tableRow/TableRowDetailAction';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';

const OrderList = () => {
    const { defaultFilters, defaultSort } = useListDefaultQueryParams();

    const [filters, setFilters] = useState<OrderTableFilters>(
        filterEmptyValues({
            ...defaultFilters,
        }) as OrderTableFilters,
    );

    const { items, pagination, isLoading, sort, setSort } = useListData<OrderListItem, OrderTableFilters>({
        endpoint: 'admin/orders',
        filters,
        setFilters,
        defaultSort,
    });

    const columns: TableColumn[] = [
        { orderBy: 'actions', label: 'ID' },
        { orderBy: 'actions', label: 'Status' },
        { orderBy: 'actions', label: 'Krok w zamówieniu' },
        { orderBy: 'actions', label: 'Wartość koszyka' },
        { orderBy: 'actions', label: 'Data utworzenia' },
        { orderBy: 'actions', label: 'Data aktualizacji' },
        { orderBy: 'actions', label: 'Akcje' },
    ];

    const renderActions = (item: OrderListItem) => (
        <div className="flex gap-2 items-center">
            <TableRowEditAction to={`${item.id}/edit`} />
            <TableRowDetailAction to={`${item.id}/details`} />
        </div>
    );

    const rowData = items.map((item: OrderListItem) => [
        <TableRowId id={item.id} />,
        item.status,
        item.checkoutStep,
        <TableRowMoney amount={item.totalPrice?.amount} symbol={item.totalPrice?.symbol} />,
        item.createdAt,
        item.updatedAt,
        renderActions(item),
    ]);

    return (
        <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
            <TableToolbar>
                <TableToolbarActions title="Lista zamówień" totalItems={pagination?.totalItems} />
                <TableToolbarFilters
                    sort={sort}
                    setSort={setSort}
                    filters={filters}
                    setFilters={setFilters}
                    defaultFilters={defaultFilters}
                    useSearch={false}
                />
            </TableToolbar>
            <TableWrapper isLoading={isLoading}>
                <TableHead sort={sort} setSort={setSort} columns={columns} />
                <TableBody data={rowData} filters={filters} pagination={pagination as Pagination} />
            </TableWrapper>
            <TablePagination filters={filters} setFilters={setFilters} pagination={pagination as Pagination} />
        </TableWithLoadingSkeleton>
    );
};

export default OrderList;
