import { useState } from 'react';
import { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowImageWithText from '@/admin/components/table/Partials/TableRow/TableRowImageWithText';
import CarrierIcon from '@/images/icons/carrier.svg';
import TableRowActiveBadge from '@/admin/components/table/Partials/TableRow/TableRowActiveBadge';
import TableRowMoney from '@/admin/components/table/Partials/TableRow/TableRowMoney';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import ListHeader from '@/admin/components/ListHeader';

const CarrierList = () => {
    const currentFilters = new URLSearchParams(location.search);
    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

    const { items, pagination, isLoading, removeItem } = useListData('admin/carriers', filters);

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, imagePath, isActive, name, fee } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            name: (
                <TableRowImageWithText
                    imagePath={imagePath}
                    text={name}
                    defaultIcon={<CarrierIcon className="text-primary mx-auto" />}
                />
            ),
            active: <TableRowActiveBadge isActive={isActive} />,
            fee: <TableRowMoney amount={fee?.amount} symbol={fee?.symbol} />,
            actions: <TableActions id={id} onDelete={() => removeItem(`admin/carriers/${id}`)} />,
        });
    });

    return (
        <>
            <PageHeader title={<ListHeader title="Przewoźnicy" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Nazwa', 'Aktywny', 'Opłata', 'Akcje']}
                items={data}
                pagination={pagination}
            />
        </>
    );
};

export default CarrierList;
