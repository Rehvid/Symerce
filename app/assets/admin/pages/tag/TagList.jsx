import { useState } from 'react';
import { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import ListHeader from '@/admin/components/ListHeader';
import useListDefaultFilters from '@/admin/hooks/useListDefaultFilters';

const TagList = () => {
    const {defaultFilters} = useListDefaultFilters();
    const [filters, setFilters] = useState(defaultFilters);

    const { items, pagination, isLoading, removeItem } = useListData('admin/tags', filters);

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, name } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            name,
            actions: <TableActions id={id} onDelete={() => removeItem(`admin/tags/${id}`)} />,
        });
    });

    return (
        <>
            <PageHeader title={<ListHeader title="Tagi" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Nazwa', 'Akcje']}
                items={data}
                pagination={pagination}
            />
        </>
    );
};
export default TagList;
