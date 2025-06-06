import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { BrandListFiltersInterface } from '@admin/modules/brand/interfaces/BrandListFiltersInterface';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import { BrandListItemInterface } from '@admin/modules/brand/interfaces/BrandListItemInterface';
import TableRowId from '@admin/components/table/Partials/TableRow/TableRowId';
import TableRowActiveBadge from '@admin/components/table/Partials/TableRow/TableRowActiveBadge';
import TableActions from '@admin/components/table/Partials/TableActions';
import { TableColumn } from '@admin/common/types/tableColumn';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/components/table/Partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';
import { TagListItemInterface } from '@admin/modules/tag/interfaces/TagListItemInterface';
import { TagListFiltersInterface } from '@admin/modules/tag/interfaces/TagListFiltersInterface';
import Link from '@admin/common/components/Link';
import EyeIcon from '@/images/icons/eye.svg';

const AttributeList = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<BrandListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<BrandListFiltersInterface>({
    endpoint: 'admin/attributes',
    filters,
    setFilters,
    defaultSort,
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const renderTableActions: ReactElement = (item) => (
    <TableActions id={item.id} onDelete={() => removeItem(`admin/attributes/${item.id}`)}>
      <Link to={`${item.id}/values`} additionalClasses="text-gray-500">
        <EyeIcon className="w-[24px] h-[24px]" />
      </Link>
    </TableActions>
  )

  const data = items.map((item: BrandListItemInterface) => {
    const { id, name, isActive } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name,
      active: <TableRowActiveBadge isActive={isActive} />,
      actions: renderTableActions(item),
    });
  });

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Atrybuty" totalItems={pagination.totalItems} />}>
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

export default AttributeList;
