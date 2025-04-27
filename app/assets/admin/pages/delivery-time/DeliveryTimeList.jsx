import { useState } from 'react';
import { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import Badge from '@/admin/components/common/Badge';
import ListHeader from '@/admin/components/ListHeader';
import useDraggable from '@/admin/hooks/useDraggable';
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';

const DeliveryTimeList = () => {
    const {defaultFilters, defaultSort} = useListDefaultQueryParams();
    const [filters, setFilters] = useState(defaultFilters);

    const { draggableCallback } = useDraggable('admin/delivery-time/order');
    const { items, pagination, isLoading, removeItem, sort, setSort } = useListData('admin/delivery-time', filters, setFilters, defaultSort);

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, label, minDays, maxDays, type } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            label,
            minDays,
            maxDays,
            type: <Badge variant="info"> {type} </Badge>,
            actions: <TableActions id={id} onDelete={() => removeItem(`admin/delivery-time/${id}`)} />,
        });
    });

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'label', label: 'Nazwa', sortable: true },
        { orderBy: 'minDays', label: 'Minimalne Dni', sortable: true },
        { orderBy: 'maxDays', label: 'Maksymalne Dni', sortable: true },
        { orderBy: 'type', label: 'Typ', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ]

    return (
        <>
            <PageHeader title={<ListHeader title="Czasy dostawy" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                filters={filters}
                setFilters={setFilters}
                columns={columns}
                items={data}
                pagination={pagination}
                additionalFilters={[]}
                useDraggable={true}
                draggableCallback={draggableCallback}
                sort={sort}
                setSort={setSort}
            />
        </>
    );
};

export default DeliveryTimeList;
