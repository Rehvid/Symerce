import useListDefaultQueryParams from '@admin/shared/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { filterEmptyValues } from '@admin/utils/helper';
import { useListData } from '@admin/shared/hooks/list/useListData';
import { CountryListItemInterface } from '@admin/modules/country/interfaces/CountryListItemInterface';
import TableRowId from '@admin/components/table/Partials/TableRow/TableRowId';
import TableActions from '@admin/components/table/Partials/TableActions';
import TableSkeleton from '@admin/components/skeleton/TableSkeleton';
import { TableColumn } from '@admin/shared/types/tableColumn';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/components/ListHeader';
import TableToolbarButtons from '@admin/components/table/Partials/TableToolbarButtons';
import DataTable from '@admin/shared/components/table/DataTable';
import { TagListFiltersInterface } from '@admin/modules/tag/interfaces/TagListFiltersInterface';
import { TagListItemInterface } from '@admin/modules/tag/interfaces/TagListItemInterface';
import TableRowActiveBadge from '@admin/components/table/Partials/TableRow/TableRowActiveBadge';

const TagListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<TagListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<TagListItemInterface>({
    endpoint: 'admin/tags',
    filters,
    setFilters,
    defaultSort,
  });

  const data = items.map((item: CountryListItemInterface) => {
    const { id, name, isActive } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name,
      active: <TableRowActiveBadge isActive={isActive} />,
      actions: <TableActions id={id} onDelete={() => removeItem(`admin/tags/${id}`)} />,
    });
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny'},
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Tagi" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  return (
    <DataTable<TagListItemInterface, TagListFiltersInterface>
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

export default TagListPage;
