import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';

const TagList = () => {
    const currentFilters = new URLSearchParams(location.search);
    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

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
            <PageHeader title={'Tagi'}>
                <Breadcrumb />
            </PageHeader>

            <DataTable
                title="Twoje tagi"
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Nazwa', 'Akcje']}
                items={data}
                pagination={pagination}
                additionalFilters={[PaginationFilter]}
                actionButtons={<TableToolbarButtons />}
            />
        </>
    );
};
export default TagList;
