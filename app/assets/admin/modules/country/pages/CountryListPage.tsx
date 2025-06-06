import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { useState } from 'react';
import { ProductListFiltersInterface } from '@admin/modules/product/interfaces/ProductListFiltersInterface';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import { CountryListItemInterface } from '@admin/modules/country/interfaces/CountryListItemInterface';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import { TableColumn } from '@admin/common/types/tableColumn';
import ActiveFilter from '@admin/common/components/table/partials/filters/ActiveFilter';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';
import { CountryListFiltersInterface } from '@admin/modules/country/interfaces/CountryListFiltersInterface';
import TableRowId from '@admin/common/components/table/partials/tableRow/TableRowId';
import TableRowActiveBadge from '@admin/common/components/table/partials/tableRow/TableRowActiveBadge';
import TableActions from '@admin/common/components/table/partials/TableActions';

const CountryListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<ProductListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<CountryListItemInterface>({
    endpoint: 'admin/countries',
    filters,
    setFilters,
    defaultSort,
  });

  const data = items.map((item: CountryListItemInterface) => {
    const { id, name, code, isActive } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name,
      code,
      active: <TableRowActiveBadge isActive={isActive} />,
      actions:  <TableActions id={id} onDelete={() => removeItem(`admin/countries/${id}`)} />,
    });
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'code', label: 'Kod', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalFilters: JSX.Element[] = [
    <ActiveFilter setFilters={setFilters} filters={filters} />,
  ];


  const additionalToolbarContent: JSX.Element = (
    <PageHeader title={<ListHeader title="Kraje" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  return (
    <DataTable<CountryListItemInterface, CountryListFiltersInterface>
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

export default CountryListPage;
