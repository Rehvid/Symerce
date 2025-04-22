import { useState } from 'react';
import { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import Badge from '@/admin/components/common/Badge';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import ListHeader from '@/admin/components/ListHeader';

const CurrencyList = () => {
    const currentFilters = new URLSearchParams(location.search);
    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

    const { items, pagination, isLoading, removeItem } = useListData('admin/currencies', filters);

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

    return (
        <>
            <PageHeader title={<ListHeader title="Waluty" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                title="Waluty"
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Nazwa', 'Symbol', 'Kod', 'Zaokrąglenie', 'Akcje']}
                items={data}
                pagination={pagination}
            />
        </>
    );
};

export default CurrencyList;
