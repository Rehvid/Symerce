import { useState } from 'react';
import { useLocation } from 'react-router-dom';
import { PAGINATION_FILTER_DEFAULT_OPTION } from '../../components/table/Filters/PaginationFilter';
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
import useListDefaultFilters from '@/admin/hooks/useListDefaultFilters';

const CategoryList = () => {
    const {defaultFilters} = useListDefaultFilters();
    const [filters, setFilters] = useState(defaultFilters);

    const { draggableCallback } = useDraggable('admin/categories/order');
    const { items, pagination, isLoading, removeItem } = useListData('admin/categories', filters);

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
            active: <TableRowActiveBadge isActive={isActive} /> ,
            actions: <TableActions id={id} onDelete={() => removeItem(`admin/categories/${id}`)} />,
        });
    });

    return (
        <>
            <PageHeader title={<ListHeader title="Kategorie" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Nazwa', 'Przyjazny URL', 'Aktywny', 'Akcje']}
                items={data}
                pagination={pagination}
                useDraggable={true}
                draggableCallback={draggableCallback}
            />
        </>
    );
};

export default CategoryList;
