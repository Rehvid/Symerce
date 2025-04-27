import { useState } from 'react';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import useListData from '@/admin/hooks/useListData';
import FoldersIcon from '@/images/icons/folders.svg';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableRowImageWithText from '@/admin/components/table/Partials/TableRow/TableRowImageWithText';
import TableActions from '@/admin/components/table/Partials/TableActions';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import useDraggable from '@/admin/hooks/useDraggable';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import ListHeader from '@/admin/components/ListHeader';
import TableRowActiveBadge from '@/admin/components/table/Partials/TableRow/TableRowActiveBadge';
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';

const CategoryList = () => {
    const { defaultFilters, defaultSort } = useListDefaultQueryParams();
    const [filters, setFilters] = useState(defaultFilters);

    const { draggableCallback } = useDraggable('admin/categories/order');
    const { items, pagination, isLoading, removeItem, sort, setSort } = useListData(
        'admin/categories',
        filters,
        setFilters,
        defaultSort,
    );

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, imagePath, name, slug, isActive } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            name: (
                <TableRowImageWithText
                    imagePath={imagePath}
                    text={name}
                    defaultIcon={<FoldersIcon className="text-primary mx-auto" />}
                />
            ),
            slug,
            active: <TableRowActiveBadge isActive={isActive} />,
            actions: <TableActions id={id} onDelete={() => removeItem(`admin/categories/${id}`)} />,
        });
    });

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'slug', label: 'Przyjazny URL', sortable: true },
        { orderBy: 'isActive', label: 'Aktywny', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    return (
        <>
            <PageHeader title={<ListHeader title="Kategorie" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

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
            />
        </>
    );
};

export default CategoryList;
