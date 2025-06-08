import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { useListData } from '@admin/common/hooks/list/useListData';
import { OrderListItemInterface } from '@admin/modules/order/interfaces/OrderListItemInterface';
import { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { OrderListFiltersInterface } from '@admin/modules/order/interfaces/OrderListFiltersInterface';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import DataTable from '@admin/common/components/table/DataTable';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import { TableColumn } from '@admin/common/types/tableColumn';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowMoney from '@admin/common/components/tableList/tableRow/TableRowMoney';
import Badge from '@admin/common/components/Badge';
import TableRowEditAction from '@admin/common/components/tableList/tableRow/TableRowEditAction';
import TableRowDetailAction from '@admin/common/components/tableList/tableRow/TableRowDetailAction';


const OrderListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();

  const [filters, setFilters] = useState<OrderListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
    }),
  );

  const { items, pagination, isLoading, sort, setSort } = useListData<OrderListItemInterface>({
    endpoint: 'admin/orders',
    filters,
    setFilters,
    defaultSort,
  });

  const columns: TableColumn[] = [
    { orderBy: 'actions', label: 'ID' },
    { orderBy: 'actions', label: 'Status' },
    { orderBy: 'actions', label: 'Krok w zamówieniu' },
    { orderBy: 'actions', label: 'Wartość koszyka' },
    { orderBy: 'actions', label: 'Data utworzenia' },
    { orderBy: 'actions', label: 'Data aktualizacji' },
    { orderBy: 'actions', label: 'Akcje' },
  ]

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const additionalToolbarContent: JSX.Element = (
    <PageHeader title={<ListHeader title="Zamówienia" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  const renderActions = (item: OrderListItemInterface) => (
    <div className="flex gap-2 items-center">
      <TableRowEditAction to={`${item.id}/edit`} />
      <TableRowDetailAction to={`${item.id}/details`}/>
    </div>
  )

  const data = items.map((item: OrderListItemInterface) => {
    const { id, status, checkoutStep, totalPrice, createdAt, updatedAt } = item
    return Object.values({
      id: <TableRowId id={id} />,
      status: <Badge> {status} </Badge>,
      checkoutStep: <Badge> {checkoutStep} </Badge>,
      totalPrice: <TableRowMoney amount={totalPrice?.amount} symbol={totalPrice?.symbol} />,
      createdAt,
      updatedAt,
      actions: renderActions(item),
    });
  });


  return (
    <DataTable<OrderListItemInterface, OrderListFiltersInterface>
      filters={filters}
      setFilters={setFilters}
      defaultFilters={defaultFilters}
      sort={sort}
      setSort={setSort}
      columns={columns}
      items={data}
      pagination={pagination}
      additionalFilters={[]}
      additionalToolbarContent={additionalToolbarContent}
    />
  );
}

export default OrderListPage;
