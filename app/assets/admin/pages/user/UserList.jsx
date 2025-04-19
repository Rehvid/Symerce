import { useLocation } from 'react-router-dom';
import { useState } from 'react';
import PaginationFilter, { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import useListData from '@/admin/hooks/useListData';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import DataTable from '@/admin/components/DataTable';
import UsersIcon from '@/images/icons/users.svg';
import TableActions from '@/admin/components/table/Partials/TableActions';
import TableRowImageWithText from '@/admin/components/table/Partials/TableRow/TableRowImageWithText';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';

const UserList = () => {
    const location = useLocation();
    const currentFilters = new URLSearchParams(location.search);

    const [filters, setFilters] = useState({
        limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentFilters.get('page')) || 1,
    });

    const { items, pagination, isLoading, removeItem } = useListData('admin/users', filters);

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, email, name, imagePath } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            name: (
                <TableRowImageWithText
                    imagePath={imagePath}
                    text={name}
                    defaultIcon={<UsersIcon className="text-primary mx-auto" />}
                />
            ),
            email,
            actions: <TableActions id={id} onDelete={() => removeItem(id)} />,
        });
    });

    return (
        <>
            <PageHeader title={'Users'}>
                <Breadcrumb />
            </PageHeader>

            <DataTable
                title="Users"
                filters={filters}
                setFilters={setFilters}
                columns={['ID', 'Użytkownik', 'Email', 'Akcje']}
                items={data}
                pagination={pagination}
                additionalFilters={[PaginationFilter]}
                actionButtons={<TableToolbarButtons />}
            />
        </>
    );
};

export default UserList;
