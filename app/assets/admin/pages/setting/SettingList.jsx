import { useState } from 'react';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowEditAction from '@/admin/components/table/Partials/TableRow/TableRowEditAction';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import Badge from '@/admin/components/common/Badge';
import ListHeader from '@/admin/components/ListHeader';
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';
import { filterEmptyValues } from '@/admin/utils/helper';
import SelectFilter from '@/admin/components/table/Filters/SelectFilter';
import RangeFilter from '@/admin/components/table/Filters/RangeFilter';

const SettingList = () => {
    const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
    const [filters, setFilters] = useState(filterEmptyValues({
        ...defaultFilters,
        type: getCurrentParam('type', (value => value)),
    }));

    const { items, pagination, isLoading, removeItem, sort, setSort, additionalData } = useListData(
        'admin/settings',
        filters,
        setFilters,
        defaultSort,
    );

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const actions = (id, isProtected) => {
        if (isProtected) {
            return (
                <div className="flex gap-2 justify-center">
                    <TableRowEditAction to={`${id}/edit`} />
                </div>
            );
        }

        return <TableActions id={id} onDelete={() => removeItem(`admin/settings/${id}`)} />;
    };

    const data = items.map((item) => {
        const { id, name, type, value, isProtected } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            name,
            type: <Badge> {type} </Badge>,
            value,
            actions: actions(id, isProtected),
        });
    });

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'name', label: 'Nazwa', sortable: true },
        { orderBy: 'type', label: 'Typ', sortable: true },
        { orderBy: 'value', label: 'Value' },
        { orderBy: 'actions', label: 'Actions' },
    ];

    const additionalFilters = [
        <SelectFilter setFilters={setFilters} filters={filters} nameFilter="type" options={additionalData?.types || []} />,
    ];

    return (
        <>
            <PageHeader title={<ListHeader title="Ustawienia" totalItems={pagination.totalItems} />}>
                <TableToolbarButtons />
            </PageHeader>

            <DataTable
                title="Globalne Ustawienia"
                filters={filters}
                setFilters={setFilters}
                columns={columns}
                items={data}
                pagination={pagination}
                sort={sort}
                setSort={setSort}
                additionalFilters={additionalFilters}
                defaultFilters={defaultFilters}
            />
        </>
    );
};

export default SettingList;
