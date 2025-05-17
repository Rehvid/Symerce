import useListDefaultQueryParams from '@/admin/hooks/useListDefaultQueryParams';
import { useState } from 'react';
import { filterEmptyValues } from '@/admin/utils/helper';
import useListData from '@/admin/hooks/useListData';
import TableSkeleton from '@/admin/components/skeleton/TableSkeleton';
import TableRowId from '@/admin/components/table/Partials/TableRow/TableRowId';
import TableRowImageWithText from '@/admin/components/table/Partials/TableRow/TableRowImageWithText';
import PaymentIcon from '@/images/icons/payment.svg';
import TableRowActiveBadge from '@/admin/components/table/Partials/TableRow/TableRowActiveBadge';
import TableRowMoney from '@/admin/components/table/Partials/TableRow/TableRowMoney';
import TableActions from '@/admin/components/table/Partials/TableActions';
import ActiveFilter from '@/admin/components/table/Filters/ActiveFilter';
import RangeFilter from '@/admin/components/table/Filters/RangeFilter';
import PageHeader from '@/admin/layouts/components/PageHeader';
import ListHeader from '@/admin/components/ListHeader';
import TableToolbarButtons from '@/admin/components/table/Partials/TableToolbarButtons';
import DataTable from '@/admin/components/DataTable';

const PaymentMethodList = () => {
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
    'admin/payment-methods',
    filters,
    setFilters,
    defaultSort,
  );

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const data = items.map((item) => {
    const { id, imagePath, isActive, name, fee, code } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name: (
        <TableRowImageWithText
          imagePath={imagePath}
          text={name}
          defaultIcon={<PaymentIcon className="text-primary mx-auto w-[24px] h-[24px]" />}
        />
      ),
      code,
      active: <TableRowActiveBadge isActive={isActive} />,
      fee: <TableRowMoney amount={fee?.amount} symbol={fee?.symbol} />,
      actions: <TableActions id={id} onDelete={() => removeItem(`admin/payment-methods/${id}`)} />,
    });
  });

  const columns = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'code', label: 'Kod' },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'fee.amount', label: 'Opłata', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalFilters = [
    <ActiveFilter setFilters={setFilters} filters={filters} />,
    <RangeFilter filters={filters} setFilters={setFilters} nameFilter="fee" label="Opłata" />,
  ];

  const additionalToolbarContent = (
    <PageHeader title={<ListHeader title="Płatności" totalItems={pagination.totalItems} />}>
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
}

export default PaymentMethodList;
