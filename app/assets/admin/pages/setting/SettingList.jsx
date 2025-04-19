import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableActions from '@/admin/components/table/Partials/TableActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableRowEditAction from '@/admin/components/table/Partials/TableRow/TableRowEditAction';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import Badge from '@/admin/components/common/Badge';

const SettingList = () => {
    const currentFilters = new URLSearchParams(location.search);
    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

    const { items, pagination, isLoading, removeItem } = useListData('admin/settings', filters);

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const actions = (id, isProtected) => {
        if (isProtected) {
            return (
                <div className="flex gap-2 items-start">
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
            type: <Badge> {type} </Badge>, //TODO: Inne dane
            value, //TODO: Dane inne wysyłamy
            actions: actions(id, isProtected),
        });
    });

    return (
        <>
            <PageHeader title={'Ustawienia'}>
                <Breadcrumb />
            </PageHeader>

            <DataTable
                title="Globalne Ustawienia"
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Nazwa', 'Typ', 'Wartość', 'Akcje']}
                items={data}
                pagination={pagination}
                additionalFilters={[PaginationFilter]}
                actionButtons={<TableToolbarButtons />}
            />
        </>
    );
};

export default SettingList;
