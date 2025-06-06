import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { TagListFiltersInterface } from '@admin/modules/tag/interfaces/TagListFiltersInterface';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import { TagListItemInterface } from '@admin/modules/tag/interfaces/TagListItemInterface';
import { CountryListItemInterface } from '@admin/modules/country/interfaces/CountryListItemInterface';
import TableRowId from '@admin/common/components/table/partials/tableRow/TableRowId';
import TableRowActiveBadge from '@admin/common/components/table/partials/tableRow/TableRowActiveBadge';
import TableActions from '@admin/common/components/table/partials/TableActions';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import { TableColumn } from '@admin/common/types/tableColumn';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';
import { WarehouseListFiltersInterface } from '@admin/modules/warehouse/interfaces/WarehouseListFiltersInterface';
import { WarehouseListItemInterface } from '@admin/modules/warehouse/interfaces/WarehouseListItemInterface';

const WarehouseList = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<WarehouseListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<WarehouseListItemInterface>({
    endpoint: 'admin/warehouses',
    filters,
    setFilters,
    defaultSort,
  });

  const data = items.map((item: WarehouseListItemInterface) => {
    const { id, name, fullAddress, isActive } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name,
      fullAddress,
      active: <TableRowActiveBadge isActive={isActive} />,
      actions: <TableActions id={id} onDelete={() => removeItem(`admin/warehouses/${id}`)} />,
    });
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'fullAddress', label: 'Adres'},
    { orderBy: 'isActive', label: 'Aktywny'},
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Magazyny" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  return (
    <DataTable<WarehouseListItemInterface, WarehouseListFiltersInterface>
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

export default WarehouseList;
