import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableActions from '@admin/common/components/tableList/TableActions';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import { TableColumn } from '@admin/common/types/tableColumn';
import TableRowImageWithText from '@admin/common/components/tableList/tableRow/TableRowImageWithText';
import FoldersIcon from '@/images/icons/folders.svg';
import { CategoryListItem } from '@admin/modules/category/interfaces/CategoryListItem';
import { CategoryTableFilters } from '@admin/modules/category/interfaces/CategoryTableFilters';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';

const CategoryList = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<CategoryTableFilters>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }) as CategoryTableFilters,
  );

    const [isComponentInit, setIsComponentInit] = useState<boolean>(false);
    const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<CategoryListItem, CategoryTableFilters>({
    endpoint: 'admin/categories',
    filters,
    setFilters,
    defaultSort,
  });

  const rowData = items.map((item: CategoryListItem) => [
      <TableRowId id={item.id} />,
      <TableRowImageWithText
          imagePath={item.imagePath}
          text={item.name}
          defaultIcon={<FoldersIcon className="text-primary mx-auto w-[24px] h-[24px]" />}
      />,
      item.slug,
      <TableRowActive isActive={item.isActive} />,
      <TableActions id={item.id} onDelete={() => removeItem(`admin/categories/${item.id}`)} />,
  ]);

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

    if (!isComponentInit && isLoading) {
        return <TableSkeleton rowsCount={filters.limit} />
    }

    if (!isComponentInit) {
        setIsComponentInit(true);
    }

  return (
      <>
          <TableToolbar>
              <TableToolbarActions title="Lista kategorii" totalItems={pagination?.totalItems} />
              <TableToolbarFilters sort={sort} setSort={setSort} filters={filters} setFilters={setFilters} defaultFilters={defaultFilters}>
                  <ActiveFilter setFilters={setFilters} filters={filters} />
              </TableToolbarFilters>
          </TableToolbar>
          <TableWrapper isLoading={isLoading}>
              <TableHead sort={sort} setSort={setSort} columns={columns} />
              <TableBody
                  data={rowData}
                  filters={filters}
                  pagination={pagination as Pagination}
              />
          </TableWrapper>
          <TablePagination
              filters={filters}
              setFilters={setFilters}
              pagination={pagination as Pagination}
          />
      </>
  );
}

export default CategoryList;
