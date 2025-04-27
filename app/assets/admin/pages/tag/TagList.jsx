import { useState } from 'react';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import ListHeader from '@/admin/components/ListHeader';
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';

const TagList = () => {
    const { defaultFilters, defaultSort } = useListDefaultQueryParams();
    const [filters, setFilters] = useState(defaultFilters);

    const { items, pagination, isLoading, removeItem, sort, setSort } = useListData(
        'admin/tags',
        filters,
        setFilters,
        defaultSort,
    );

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

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    return (
        <>
            <PageHeader title={<ListHeader title="Tagi" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                filters={filters}
                setFilters={setFilters}
                columns={columns}
                items={data}
                pagination={pagination}
                sort={sort}
                setSort={setSort}
            />
        </>
    );
};
export default TagList;
