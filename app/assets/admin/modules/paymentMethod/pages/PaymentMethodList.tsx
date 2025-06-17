import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { PaymentMethodTableFilters } from '@admin/modules/paymentMethod/interfaces/PaymentMethodTableFilters';
import { useListData } from '@admin/common/hooks/list/useListData';
import { PaymentMethodListItem } from '@admin/modules/paymentMethod/interfaces/PaymentMethodListItem';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableActions from '@admin/common/components/tableList/TableActions';
import TableRowImageWithText from '@admin/common/components/tableList/tableRow/TableRowImageWithText';
import TableRowMoney from '@admin/common/components/tableList/tableRow/TableRowMoney';
import { TableColumn } from '@admin/common/types/tableColumn';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import PaymentIcon from '@/images/icons/payment.svg';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import RangeFilter from '@admin/common/components/tableList/filters/RangeFilter';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';
import useDraggable from '@admin/common/hooks/list/useDraggable';

const PaymentMethodList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
    const [filters, setFilters] = useState<PaymentMethodTableFilters>(
        filterEmptyValues({
            ...defaultFilters,
            isActive: getCurrentParam('isActive', (value) => Boolean(value)),
            feeFrom: getCurrentParam('feeFrom', (value) => Number(value)),
            feeTo: getCurrentParam('feeTo', (value) => Number(value)),
            search: getCurrentParam('search', (value) => String(value)),
        }) as PaymentMethodTableFilters,
    );
    const { draggableCallback } = useDraggable('admin/position/paymentMethod');
    const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<
        PaymentMethodListItem,
        PaymentMethodTableFilters
    >({
        endpoint: 'admin/payment-methods',
        filters,
        setFilters,
        defaultSort,
    });

    const rowData = items.map((item: PaymentMethodListItem) => [
        <TableRowId id={item.id} />,
        <TableRowImageWithText
            imagePath={item.imagePath}
            text={item.name}
            defaultIcon={<PaymentIcon className="text-primary mx-auto w-[24px] h-[24px]" />}
        />,
        item.code,
        <TableRowMoney symbol={item.fee.symbol} amount={item.fee.amount} />,
        <TableRowActive isActive={item.isActive} />,
        <TableActions id={item.id} onDelete={() => removeItem(`admin/payment-methods/${item.id}`)} />,
    ]);

    const columns: TableColumn[] = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'code', label: 'Kod', sortable: true },
        { orderBy: 'fee', label: 'Prowizja', sortable: true },
        { orderBy: 'isActive', label: 'Aktywny', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    return (
        <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
            <TableToolbar>
                <TableToolbarActions title="Lista płatności" totalItems={pagination?.totalItems} />
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

export default PaymentMethodList;
