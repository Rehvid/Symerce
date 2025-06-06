import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { BrandListFiltersInterface } from '@admin/modules/brand/interfaces/BrandListFiltersInterface';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import { useParams } from 'react-router-dom';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import { TableColumn } from '@admin/common/types/tableColumn';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/common/components/table/partials/TableToolbarButtons';
import DataTable from '@admin/common/components/table/DataTable';
import { TagListItemInterface } from '@admin/modules/tag/interfaces/TagListItemInterface';
import { TagListFiltersInterface } from '@admin/modules/tag/interfaces/TagListFiltersInterface';
import TableRowId from '@admin/common/components/table/partials/tableRow/TableRowId';
import TableActions from '@admin/common/components/table/partials/TableActions';
import { BrandListItemInterface } from '@admin/modules/brand/interfaces/BrandListItemInterface';

const AttributeValueList = () => {
  const params = useParams();
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<BrandListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<BrandListFiltersInterface>({
    endpoint: `admin/attributes/${params.attributeId}/values`,
    filters,
    setFilters,
    defaultSort,
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const data = items.map((item: BrandListItemInterface) => {
    const { id, value } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      value,
      actions:
        <TableActions
          id={id}
          onDelete={() => removeItem(`admin/attributes/${params.attributeId}/values/${id}`)}
        />,
    });
  });

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'value', label: 'Wartość', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Grupa wartości" totalItems={pagination.totalItems} />}>
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

export default AttributeValueList;
