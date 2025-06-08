import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowImageWithText from '@admin/common/components/tableList/tableRow/TableRowImageWithText';
import UsersIcon from '@/images/icons/users.svg';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableActions from '@admin/common/components/tableList/TableActions';
import { UserListItemInterface } from '@admin/modules/user/interfaces/UserListItemInterface';
import { TableColumn } from '@admin/common/types/tableColumn';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import { UserListFiltersInterface } from '@admin/modules/user/interfaces/UserListFiltersInterface';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';

const UserListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<UserListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<UserListItemInterface>({
    endpoint: 'admin/users',
    filters,
    setFilters,
    defaultSort,
  });


  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const data = items.map((item: UserListItemInterface) => {
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
      active: <TableRowActive isActive={isActive} />,
      actions: <TableActions id={id} onDelete={() => removeItem(`admin/users/${item.id}`)} />,
    });
  });

  const columns: TableColumn[]  = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'fullName', label: 'Użytkownik' },
    { orderBy: 'email', label: 'Email', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Użytkownicy panelu" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  return (
    <DataTable<UserListItemInterface, UserListFiltersInterface>
      filters={filters}
      setFilters={setFilters}
      defaultFilters={defaultFilters}
      sort={sort}
      setSort={setSort}
      columns={columns}
      items={data}
      pagination={pagination}
      additionalToolbarContent={additionalToolbarContent}
    />
  );
}


export default UserListPage;
