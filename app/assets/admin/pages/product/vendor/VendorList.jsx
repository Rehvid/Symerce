import { useState } from 'react';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import ProductIcon from '@/images/icons/assembly.svg';
import TableRowImageWithText from '@/admin/components/table/Partials/TableRow/TableRowImageWithText';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import ListHeader from '@/admin/components/ListHeader';
import TableRowActiveBadge from '@/admin/components/table/Partials/TableRow/TableRowActiveBadge';
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';
import { filterEmptyValues } from '@/admin/utils/helper';
import ActiveFilter from '@/admin/components/table/Filters/ActiveFilter';

const VendorList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
    const [filters, setFilters] = useState(
        filterEmptyValues({
            ...defaultFilters,
            isActive: getCurrentParam('isActive', (value) => Boolean(value)),
        }),
    );

    const { items, pagination, isLoading, removeItem, sort, setSort } = useListData(
        'admin/vendors',
        filters,
        setFilters,
        defaultSort,
    );

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, name, imagePath, isActive } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            name: (
                <TableRowImageWithText
                    imagePath={imagePath}
                    text={name}
                    defaultIcon={<ProductIcon className="text-primary mx-auto" />}
                />
            ),
            active: <TableRowActiveBadge isActive={isActive} />,
            actions: <TableActions id={id} onDelete={() => removeItem(`admin/vendors/${item.id}`)} />,
        });
    });

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'isActive', label: 'Aktywny', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    const additionalFilters = [<ActiveFilter filters={filters} setFilters={setFilters} />];

    return (
        <>
            <PageHeader title={<ListHeader title="Producenci" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                filters={filters}
                setFilters={setFilters}
                columns={columns}
                items={data}
                pagination={pagination}
                sort={sort}
                setSort={setSort}
                defaultFilters={defaultFilters}
                additionalFilters={additionalFilters}
            />
        </>
    );
};

export default VendorList;
