import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import { ReactElement, useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
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
import TableRowImageWithText from '@admin/common/components/table/partials/tableRow/TableRowImageWithText';
import FoldersIcon from '@/images/icons/folders.svg';
import { CategoryListItemInterface } from '@admin/modules/category/interfaces/CategoryListItemInterface';
import { CategoryListFiltersInterface } from '@admin/modules/category/interfaces/CategoryListFiltersInterface';

const CategoryListPage = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<CategoryListFiltersInterface>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }),
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<CategoryListItemInterface>({
    endpoint: 'admin/categories',
    filters,
    setFilters,
    defaultSort,
  });

  const data = items.map((item: CountryListItemInterface) => {
    const { id, imagePath, name, slug, isActive } = item;
    return Object.values({
      id: <TableRowId id={id} />,
      name: (
        <TableRowImageWithText
          imagePath={imagePath}
          text={name}
          defaultIcon={<FoldersIcon className="text-primary mx-auto w-[24px] h-[24px]" />}
        />
      ),
      slug,
      active: <TableRowActiveBadge isActive={isActive} />,
      actions: <TableActions id={id} onDelete={() => removeItem(`admin/categories/${id}`)} />,
    });
  });

  if (isLoading) {
    return <TableSkeleton rowsCount={filters.limit} />;
  }

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'slug', label: 'Przyjazny URL', sortable: true },
    { orderBy: 'isActive', label: 'Aktywny', sortable: true },
    { orderBy: 'actions', label: 'Actions' },
  ];

  const additionalToolbarContent: ReactElement = (
    <PageHeader title={<ListHeader title="Kategorie" totalItems={pagination.totalItems} />}>
      <TableToolbarButtons />
    </PageHeader>
  );

  return (
    <DataTable<CategoryListItemInterface, CategoryListFiltersInterface>
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

export default CategoryListPage;
