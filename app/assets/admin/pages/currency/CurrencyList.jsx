import { useState } from 'react';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import Badge from '@/admin/components/common/Badge';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import ListHeader from '@/admin/components/ListHeader';
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';
import { filterEmptyValues } from '@/admin/utils/helper';
import RangeFilter from '@/admin/components/table/Filters/RangeFilter';

const CurrencyList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
    const [filters, setFilters] = useState(
        filterEmptyValues({
            ...defaultFilters,
            roundingPrecisionFrom: getCurrentParam('roundingPrecisionFrom', (value) => Number(value)),
            roundingPrecisionTo: getCurrentParam('roundingPrecisionTo', (value) => Number(value)),
        }),
    );

    const { items, pagination, isLoading, removeItem, sort, setSort } = useListData(
        'admin/currencies',
        filters,
        setFilters,
        defaultSort,
    );

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, name, symbol, code, roundingPrecision } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            name,
            symbol,
            code,
            roundingPrecision: (
                <Badge variant="info">
                    <strong>{roundingPrecision}</strong>
                </Badge>
            ),
            actions: <TableActions id={id} onDelete={() => removeItem(`admin/currencies/${id}`)} />,
        });
    });

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'symbol', label: 'Symbol', sortable: true },
        { orderBy: 'code', label: 'Kod', sortable: true },
        { orderBy: 'roundingPrecision', label: 'Zaokrąglenie', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    const additionalFilters = [
        <RangeFilter filters={filters} setFilters={setFilters} label="Zaokrąglenie" nameFilter="roundingPrecision" />,
    ];

    return (
        <>
            <PageHeader title={<ListHeader title="Waluty" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                title="Waluty"
                filters={filters}
                setFilters={setFilters}
                columns={columns}
                items={data}
                pagination={pagination}
                sort={sort}
                setSort={setSort}
                additionalFilters={additionalFilters}
                defaultFilters={defaultFilters}
            />
        </>
    );
};

export default CurrencyList;
