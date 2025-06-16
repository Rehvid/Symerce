import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableActions from '@admin/common/components/tableList/TableActions';
import { TableColumn } from '@admin/common/types/tableColumn';
import { CurrencyTableFilters } from '@admin/modules/currency/interfaces/CurrencyTableFilters';
import { CurrencyListItem } from '@admin/modules/currency/interfaces/CurrencyListItem';
import RangeFilter from '@admin/common/components/tableList/filters/RangeFilter';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';

const CurrencyListPage = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
    const [filters, setFilters] = useState<CurrencyTableFilters>(
        filterEmptyValues({
            ...defaultFilters,
            roundingPrecisionFrom: getCurrentParam('roundingPrecisionFrom', (value) => Number(value)),
            roundingPrecisionTo: getCurrentParam('roundingPrecisionTo', (value) => Number(value)),
            search: getCurrentParam('search', (value) => String(value)),
        }) as CurrencyTableFilters,
    );

    const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<
        CurrencyListItem,
        CurrencyTableFilters
    >({
        endpoint: 'admin/currencies',
        filters,
        setFilters,
        defaultSort,
    });

    const rowData = items.map((item: CurrencyListItem) => [
        <TableRowId id={item.id} />,
        item.name,
        item.symbol,
        item.code,
        item.roundingPrecision,
        <TableActions id={item.id} onDelete={() => removeItem(`admin/currencies/${item.id}`)} />,
    ]);

    const columns: TableColumn[] = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'symbol', label: 'Symbol', sortable: true },
        { orderBy: 'code', label: 'Kod', sortable: true },
        { orderBy: 'roundingPrecision', label: 'Zaokrąglenie', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    return (
        <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
            <TableToolbar>
                <TableToolbarActions title="Lista walut" totalItems={pagination?.totalItems} />
                <TableToolbarFilters
                    sort={sort}
                    setSort={setSort}
                    filters={filters}
                    setFilters={setFilters}
                    defaultFilters={defaultFilters}
                >
                    <ActiveFilter setFilters={setFilters} filters={filters} />
                    <RangeFilter
                        filters={filters}
                        setFilters={setFilters}
                        label="Zaokrąglenie"
                        nameFilter="roundingPrecision"
                    />
                </TableToolbarFilters>
            </TableToolbar>
            <TableWrapper isLoading={isLoading}>
                <TableHead sort={sort} setSort={setSort} columns={columns} />
                <TableBody data={rowData} filters={filters} pagination={pagination as Pagination} />
            </TableWrapper>
            <TablePagination filters={filters} setFilters={setFilters} pagination={pagination as Pagination} />
        </TableWithLoadingSkeleton>
    );
};

export default CurrencyListPage;
