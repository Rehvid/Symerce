import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { UserListFiltersInterface } from '@admin/modules/user/interfaces/UserListFiltersInterface';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import { UserListItemInterface } from '@admin/modules/user/interfaces/UserListItemInterface';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowImageWithText from '@admin/common/components/tableList/tableRow/TableRowImageWithText';
import UsersIcon from '@/images/icons/users.svg';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableActions from '@admin/common/components/tableList/TableActions';
import { TableColumn } from '@admin/common/types/tableColumn';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';
import TableRowShowAction from '@admin/common/components/tableList/tableRow/TableRowExternalLinkAction';
import TableRowDetailAction from '@admin/common/components/tableList/tableRow/TableRowDetailAction';
import Link from '@admin/common/components/Link';

const CartList = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<UserListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<UserListItemInterface>({
    endpoint: 'admin/carts',
    filters,
    setFilters,
    defaultSort,
  });


  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const data = items.map((item: UserListItemInterface) => {
    const { id, orderId, customer, total, createdAt, updatedAt, expiresAt } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      orderId: orderId ? <Link to={`/admin/orders/${orderId}/details`} >Zamówienie</Link> : '-',
      customer,
      total,
      createdAt,
      updatedAt,
      expiresAt,
      actions: <TableRowDetailAction to={`${item.id}/details`} />
    });
  });

  const columns: TableColumn[]  = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'orderId', label: 'Zamówienie', sortable: true },
    { orderBy: 'customer', label: 'Klient', sortable: true },
    { orderBy: 'total', label: 'Total', sortable: true },
    { orderBy: 'createdAt', label: 'Utworzono', sortable: true },
    { orderBy: 'updatedAt', label: 'Ostatnia aktualizacja', sortable: true },
    { orderBy: 'expiresAt', label: 'Koszyk wygasa', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Koszyk" totalItems={pagination.totalItems} />} />
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

export default CartList;
