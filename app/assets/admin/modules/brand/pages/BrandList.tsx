import { TableColumn } from '@admin/common/types/tableColumn';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import { BrandListItem } from '@admin/modules/brand/interfaces/BrandListItem';
import TableRowImageWithText from '@admin/common/components/tableList/tableRow/TableRowImageWithText';
import ProductIcon from '@/images/icons/assembly.svg';
import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import { BrandTableFilters } from '@admin/modules/brand/interfaces/BrandTableFilters';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';
import TableActions from '@admin/common/components/tableList/TableActions';

const BrandList = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<BrandTableFilters>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }) as BrandTableFilters,
  );

  const [isComponentInit, setIsComponentInit] = useState<boolean>(false);
  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<BrandListItem, BrandTableFilters>({
    endpoint: 'admin/brands',
    filters,
    setFilters,
    defaultSort,
  });


  const rowData = items.map((item: BrandListItem) => [
        <TableRowId id={item.id} />,
        <TableRowImageWithText
            imagePath={item.image}
            text={item.name}
            defaultIcon={<ProductIcon className="text-primary mx-auto" />}
        />,
        <TableRowActive isActive={item.isActive} />,
        <TableActions id={item.id} onDelete={() => removeItem(`admin/brands/${item.id}`)} />,
    ]);

  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
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
              <TableToolbarActions title="Lista marek" totalItems={pagination?.totalItems} />
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

export default BrandList;
