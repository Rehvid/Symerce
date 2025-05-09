import { useState } from 'react';
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
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';

const AttributeList = () => {
    const { defaultFilters, defaultSort } = useListDefaultQueryParams();
    const [filters, setFilters] = useState(defaultFilters);

    const { draggableCallback } = useDraggable('admin/attributes/order');
    const { items, pagination, isLoading, removeItem, sort, setSort } = useListData(
        'admin/attributes',
        filters,
        setFilters,
        defaultSort,
    );

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const actions = (id, name) => (
        <TableActions id={id} onDelete={() => removeItem(`admin/attributes/${id}`)}>
            <AppLink to={`${id}/values`} state={{ name }} additionalClasses="text-gray-500">
                <EyeIcon className="w-[24px] h-[24px]" />
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

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    const additionalToolbarContent = (
        <PageHeader title={<ListHeader title="Atrybuty" totalItems={pagination.totalItems} />}>
            <TableToolbarButtons />
        </PageHeader>
    );

    return (
        <DataTable
            filters={filters}
            setFilters={setFilters}
            columns={columns}
            items={data}
            pagination={pagination}
            useDraggable={true}
            draggableCallback={draggableCallback}
            sort={sort}
            setSort={setSort}
            additionalToolbarContent={additionalToolbarContent}
        />
    );
};

export default AttributeList;
