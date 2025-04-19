import { useLocation, useParams } from 'react-router-dom';
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

const AttributeValueList = () => {
    const location = useLocation();
    const currentFilters = new URLSearchParams(location.search);
    const params = useParams();
    const { name } = location.state || {};

    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

    const { items, pagination, isLoading, removeItem } = useListData(`admin/attributes/${params.id}/values`, filters);

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

    return (
        <>
            <PageHeader title={`${name ? `Grupa - ${name}` : 'Grupa Wartości'}`}>
                <Breadcrumb />
            </PageHeader>

            <DataTable
                title="Wartości"
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Wartości', 'Akcje']}
                items={data}
                pagination={pagination}
                additionalFilters={[PaginationFilter]}
                actionButtons={<TableToolbarButtons />}
            />
        </>
    );
};

export default AttributeValueList;
