import { useLocation } from 'react-router-dom';
import { useState } from 'react';
import { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableActions from '@/admin/components/table/Partials/TableActions';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import AppLink from '@/admin/components/common/AppLink';
import EyeIcon from '@/images/icons/eye.svg';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import ListHeader from '@/admin/components/ListHeader';
import useDraggable from '@/admin/hooks/useDraggable';

const AttributeList = () => {
    const location = useLocation();
    const currentFilters = new URLSearchParams(location.search);

    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

    const { draggableCallback } = useDraggable('admin/attributes/order');
    const { items, pagination, isLoading, removeItem } = useListData('admin/attributes', filters);

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const actions = (id, name) => (
        <TableActions id={id} onDelete={() => removeItem(`admin/attributes/${id}`)}>
            <AppLink to={`${id}/values`} state={{ name }} additionalClasses="text-gray-500">
                <EyeIcon />
            </AppLink>
        </TableActions>
    );

    const data = items.map((item) => {
        const { id, name } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            name,
            actions: actions(id, name),
        });
    });

    return (
        <>
            <PageHeader title={<ListHeader title="Atrybuty" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Nazwa', 'Akcje']}
                items={data}
                pagination={pagination}
                useDraggable={true}
                draggableCallback={draggableCallback}
            />
        </>
    );
};

export default AttributeList;
