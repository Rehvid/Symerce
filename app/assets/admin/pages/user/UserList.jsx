import { useState } from 'react';
import useListData from '@/admin/hooks/useListData';
import PageHeader from '@/admin/layouts/components/PageHeader';
import DataTable from '@/admin/components/DataTable';
import UsersIcon from '@/images/icons/users.svg';
import TableActions from '@/admin/components/table/Partials/TableActions';
import TableRowImageWithText from '@/admin/components/table/Partials/TableRow/TableRowImageWithText';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import ListHeader from '@/admin/components/ListHeader';
import TableRowActiveBadge from '@/admin/components/table/Partials/TableRow/TableRowActiveBadge';
import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';

const UserList = () => {
    const { defaultFilters, defaultSort } = useListDefaultQueryParams();
    const [filters, setFilters] = useState(defaultFilters);

    const { items, pagination, isLoading, removeItem, sort, setSort } = useListData(
        'admin/users',
        filters,
        setFilters,
        defaultSort,
    );

    if (isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />;
    }

    const data = items.map((item) => {
        const { id, email, fullName, imagePath, isActive } = item;
        return Object.values({
            id: <TableRowId id={id} />,
            name: (
                <TableRowImageWithText
                    imagePath={imagePath}
                    text={fullName}
                    defaultIcon={<UsersIcon className="text-primary mx-auto" />}
                />
            ),
            email,
            active: <TableRowActiveBadge isActive={isActive} />,
            actions: <TableActions id={id} onDelete={() => removeItem(id)} />,
        });
    });

    const columns = [
        { orderBy: 'id', label: 'ID', sortable: true },
        { orderBy: 'fullName', label: 'Użytkownik' },
        { orderBy: 'email', label: 'Email', sortable: true },
        { orderBy: 'isActive', label: 'Aktywny', sortable: true },
        { orderBy: 'actions', label: 'Actions' },
    ];

    return (
        <>
            <PageHeader title={<ListHeader title="Użytkownicy" totalItems={pagination.totalItems} />}>
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
            />
        </>
    );
};

export default UserList;
