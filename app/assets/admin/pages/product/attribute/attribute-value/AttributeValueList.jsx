import { useLocation, useParams } from 'react-router-dom';
import { useState } from 'react';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import ListHeader from '@/admin/components/ListHeader';
import useDraggable from '@/admin/hooks/useDraggable';
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';

const AttributeValueList = () => {
    const location = useLocation();
    const params = useParams();
    const { name } = location.state || {};

    const {defaultFilters, defaultSort} = useListDefaultQueryParams();
    const [filters, setFilters] = useState(defaultFilters);

    const { draggableCallback } = useDraggable(`admin/attributes/${params.attributeId}/values/order`);
    const { items, pagination, isLoading, removeItem, sort, setSort } = useListData(`admin/attributes/${params.attributeId}/values`, filters, setFilters, defaultSort);

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, value } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            value,
            actions: (
                <TableActions
                    id={id}
                    onDelete={() => removeItem(`admin/attributes/${params.attributeId}/values/${id}`)}
                />
            ),
        });
    });

    const pageTitle = `${name ? `Grupa - ${name}` : 'Grupa Wartości'}`;

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'value', label: 'Wartość', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    return (
        <>
            <PageHeader title={<ListHeader title={pageTitle} totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                title="Wartości"
                filters={filters}
                setFilters={setFilters}
                columns={columns}
                items={data}
                pagination={pagination}
                useDraggable={true}
                draggableCallback={draggableCallback}
                sort={sort}
                setSort={setSort}
            />
        </>
    );
};

export default AttributeValueList;
