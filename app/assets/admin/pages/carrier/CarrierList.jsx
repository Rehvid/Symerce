import { useState } from 'react';
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
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';
import ActiveFilter from '@/admin/components/table/Filters/ActiveFilter';
import RangeFilter from '@/admin/components/table/Filters/RangeFilter';
import { filterEmptyValues } from '@/admin/utils/helper';

const CarrierList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
    const [filters, setFilters] = useState(
        filterEmptyValues({
            ...defaultFilters,
            isActive: getCurrentParam('isActive', (value) => Boolean(value)),
            feeFrom: getCurrentParam('feeFrom', (value) => Number(value)),
            feeTo: getCurrentParam('feeTo', (value) => Number(value)),
        }),
    );

    const { items, pagination, isLoading, removeItem, sort, setSort } = useListData(
        'admin/carriers',
        filters,
        setFilters,
        defaultSort,
    );

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

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'isActive', label: 'Aktywny', sortable: true },
        { orderBy: 'fee.amount', label: 'Opłata', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    const additionalFilters = [
        <ActiveFilter setFilters={setFilters} filters={filters} />,
        <RangeFilter filters={filters} setFilters={setFilters} nameFilter="fee" label="Opłata" />,
    ];

    const additionalToolbarContent = (
        <PageHeader title={<ListHeader title="Przewoźnicy" totalItems={pagination.totalItems} />}>
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
            sort={sort}
            setSort={setSort}
            additionalFilters={additionalFilters}
            defaultFilters={defaultFilters}
            additionalToolbarContent={additionalToolbarContent}
        />
    );
};

export default CarrierList;
