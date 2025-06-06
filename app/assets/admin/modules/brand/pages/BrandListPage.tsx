import DataTable from '@admin/common/components/table/DataTable';
import { TagListItemInterface } from '@admin/modules/tag/interfaces/TagListItemInterface';
import { TagListFiltersInterface } from '@admin/modules/tag/interfaces/TagListFiltersInterface';
import { TableColumn } from '@admin/common/types/tableColumn';
import TableRowId from '@admin/components/table/Partials/TableRow/TableRowId';
import TableRowActiveBadge from '@admin/components/table/Partials/TableRow/TableRowActiveBadge';
import TableActions from '@admin/components/table/Partials/TableActions';
import { BrandListItemInterface } from '@admin/modules/brand/interfaces/BrandListItemInterface';
import TableRowImageWithText from '@admin/components/table/Partials/TableRow/TableRowImageWithText';
import ProductIcon from '@/images/icons/assembly.svg';
import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import { BrandListFiltersInterface } from '@admin/modules/brand/interfaces/BrandListFiltersInterface';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import PageHeader from '@admin/layouts/components/PageHeader';
import ListHeader from '@admin/common/components/ListHeader';
import TableToolbarButtons from '@admin/components/table/Partials/TableToolbarButtons';

const BrandListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<BrandListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<BrandListFiltersInterface>({
    endpoint: 'admin/brands',
    filters,
    setFilters,
    defaultSort,
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const data = items.map((item: BrandListItemInterface) => {
    const { id, name, imagePath, isActive } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name: <TableRowImageWithText
        imagePath={imagePath}
        text={name}
        defaultIcon={<ProductIcon className="text-primary mx-auto" />}
      />,
      active: <TableRowActiveBadge isActive={isActive} />,
      actions: <TableActions id={id} onDelete={() => removeItem(`admin/brands/${item.id}`)} />,
    });
  });

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Marki" totalItems={pagination.totalItems} />}>
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

export default BrandListPage;
