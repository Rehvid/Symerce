import { useState } from 'react';
import { useLocation } from 'react-router-dom';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '../../components/table/Filters/PaginationFilter';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import useListData from '@/admin/hooks/useListData';
import FoldersIcon from '@/images/icons/folders.svg';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableRowImageWithText from '@/admin/components/table/Partials/TableRow/TableRowImageWithText';
import TableActions from '@/admin/components/table/Partials/TableActions';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import useDraggable from '@/admin/hooks/useDraggable';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';

const CategoryList = () => {
    const location = useLocation();
    const currentFilters = new URLSearchParams(location.search);
    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

    const { draggableCallback } = useDraggable('admin/categories/order');
    const { items, pagination, isLoading, removeItem } = useListData('admin/categories', filters);

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, imagePath, name, slug } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            name: (
                <TableRowImageWithText
                    imagePath={imagePath}
                    text={name}
                    defaultIcon={<FoldersIcon className="text-primary mx-auto" />}
                />
            ),
            slug: slug,
            actions: <TableActions id={id} onDelete={() => removeItem(`admin/categories/${id}`)} />,
        });
    });

    return (
        <>
            <PageHeader title={'Categoriesa'}>
                <Breadcrumb />
            </PageHeader>

            <DataTable
                title="Your categories"
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Nazwa', 'Przyjazny URL', 'Akcje']}
                items={data}
                pagination={pagination}
                additionalFilters={[PaginationFilter]}
                actionButtons={<TableToolbarButtons />}
                useDraggable={true}
                draggableCallback={draggableCallback}
            />
        </>
    );
};

export default CategoryList;
