import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import {
  PaymentMethodListFiltersInterface
} from '@admin/modules/paymentMethod/interfaces/PaymentMethodListFiltersInterface';
import { useListData } from '@admin/common/hooks/list/useListData';
import { PaymentMethodListItemInterface } from '@admin/modules/paymentMethod/interfaces/PaymentMethodListItemInterface';
import TableRowActiveBadge from '@admin/common/components/table/partials/tableRow/TableRowActiveBadge';
import TableActions from '@admin/common/components/table/partials/TableActions';
import TableRowImageWithText from '@admin/common/components/table/partials/tableRow/TableRowImageWithText';
import TableRowMoney from '@admin/common/components/table/partials/tableRow/TableRowMoney';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import { TableColumn } from '@admin/common/types/tableColumn';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';
import TableRowId from '@admin/common/components/table/partials/tableRow/TableRowId';
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
