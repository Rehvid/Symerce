import useListDefaultQueryParams from '@admin/shared/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { filterEmptyValues } from '@admin/utils/helper';
import {
  PaymentMethodListFiltersInterface
} from '@admin/modules/paymentMethod/interfaces/PaymentMethodListFiltersInterface';
import { useListData } from '@admin/shared/hooks/list/useListData';
import { PaymentMethodListItemInterface } from '@admin/modules/paymentMethod/interfaces/PaymentMethodListItemInterface';
import TableRowActiveBadge from '@admin/components/table/Partials/TableRow/TableRowActiveBadge';
import TableActions from '@admin/components/table/Partials/TableActions';
import TableRowImageWithText from '@admin/components/table/Partials/TableRow/TableRowImageWithText';
import TableRowMoney from '@admin/components/table/Partials/TableRow/TableRowMoney';
import TableSkeleton from '@admin/components/skeleton/TableSkeleton';
import { TableColumn } from '@admin/shared/types/tableColumn';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/components/ListHeader';
import TableToolbarButtons from '@admin/components/table/Partials/TableToolbarButtons';
import DataTable from '@admin/shared/components/table/DataTable';
import TableRowId from '@admin/components/table/Partials/TableRow/TableRowId';
import PaymentIcon from '@/images/icons/payment.svg';

const PaymentMethodListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<PaymentMethodListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<PaymentMethodListItemInterface>({
    endpoint: 'admin/payment-methods',
    filters,
    setFilters,
    defaultSort,
  });

  const data = items.map((item: PaymentMethodListItemInterface) => {
    const { id, name, code, isActive, imagePath, fee } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name: <TableRowImageWithText
        imagePath={imagePath}
        text={name}
        defaultIcon={<PaymentIcon className="text-primary mx-auto w-[24px] h-[24px]" />}
      />,
      code,
      fee: <TableRowMoney symbol={fee.symbol} amount={fee.amount} />,
      active: <TableRowActiveBadge isActive={isActive} />,
      actions:  <TableActions id={id} onDelete={() => removeItem(`admin/payment-methods/${id}`)} />,
    });
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', },
    { orderBy: 'code', label: 'Kod', sortable: true },
    { orderBy: 'fee', label: 'Prowizja' },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Metody płatności" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  return (
    <DataTable<PaymentMethodListItemInterface, PaymentMethodListFiltersInterface>
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

export default PaymentMethodListPage;
