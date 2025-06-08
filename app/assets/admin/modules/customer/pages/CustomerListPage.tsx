import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import { CountryListItemInterface } from '@admin/modules/country/interfaces/CountryListItemInterface';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableActions from '@admin/common/components/tableList/TableActions';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import { TableColumn } from '@admin/common/types/tableColumn';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';
import { CustomerListFiltersInterface } from '@admin/modules/customer/interfaces/CustomerListFiltersInterface';
import { CustomerListItemInterface } from '@admin/modules/customer/interfaces/CustomerListItemInterface';

const CustomerListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<CustomerListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<CustomerListItemInterface>({
    endpoint: 'admin/customers',
    filters,
    setFilters,
    defaultSort,
  });

  const data = items.map((item: CustomerListItemInterface) => {
    const { id, fullName, email, isActive } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      fullName,
      email,
      active: <TableRowActive isActive={isActive} />,
      actions:  <TableActions id={id} onDelete={() => removeItem(`admin/customers/${id}`)} />,
    });
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'fullName', label: 'Użytkownik', sortable: true },
    { orderBy: 'email', label: 'Email', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalFilters: JSX.Element[] = [
    <ActiveFilter setFilters={setFilters} filters={filters} />,
  ];


  const additionalToolbarContent: JSX.Element = (
    <PageHeader title={<ListHeader title="Klienci" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  return (
    <DataTable<CustomerListItemInterface, CustomerListFiltersInterface>
      filters={filters}
      setFilters={setFilters}
      defaultFilters={defaultFilters}
      sort={sort}
      setSort={setSort}
      columns={columns}
      items={data}
      pagination={pagination}
      additionalFilters={additionalFilters}
      additionalToolbarContent={additionalToolbarContent}
    />
  );
}

export default CustomerListPage;
