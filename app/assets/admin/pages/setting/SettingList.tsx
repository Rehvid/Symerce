import useListDefaultQueryParams from '@admin/shared/hooks/list/useListDefaultQueryParams';
import { useState } from 'react';
import { filterEmptyValues } from '@admin/utils/helper';
import { SettingListFiltersInterface } from '@admin/modules/setting/interfaces/SettingListFiltersInterface';
import { useListData } from '@admin/shared/hooks/list/useListData';
import { SettingListItemInterface } from '@admin/modules/setting/interfaces/SettingListItemInterface';
import TableSkeleton from '@admin/components/skeleton/TableSkeleton';
import { TableColumn } from '@admin/shared/types/tableColumn';
import TableRowId from '@admin/components/table/Partials/TableRow/TableRowId';
import TableRowActiveBadge from '@admin/components/table/Partials/TableRow/TableRowActiveBadge';
import DataTable from '@admin/shared/components/table/DataTable';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/components/ListHeader';
import TableRowEditAction from '@admin/components/table/Partials/TableRow/TableRowEditAction';

const SettingList = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();

  const [filters, setFilters] = useState<SettingListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<SettingListItemInterface>({
    endpoint: 'admin/settings',
    filters,
    setFilters,
    defaultSort,
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const data = items.map((item: SettingListItemInterface) => {
    const { id, name, isActive, type } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name,
      type,
      active: <TableRowActiveBadge isActive={isActive} />,
      actions:  <TableRowEditAction to={`${id}/edit`} />,
    });
  });

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'settingType', label: 'Typ', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: JSX.Element = (
    <PageHeader title={<ListHeader title="Ustawienia" totalItems={pagination.totalItems} />} />
  );

  return (
    <DataTable<SettingListItemInterface, SettingListFiltersInterface>
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

export default SettingList;
