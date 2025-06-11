import useListDefaultQueryParams from '@admin/common/hooks/list/useListDefaultQueryParams';
import React, { useState } from 'react';
import { filterEmptyValues } from '@admin/common/utils/helper';
import { useListData } from '@admin/common/hooks/list/useListData';
import TableRowId from '@admin/common/components/tableList/tableRow/TableRowId';
import TableRowActive from '@admin/common/components/tableList/tableRow/TableRowActive';
import TableActions from '@admin/common/components/tableList/TableActions';
import { TableColumn } from '@admin/common/types/tableColumn';
import { WarehouseTableFilters } from '@admin/modules/warehouse/interfaces/WarehouseTableFilters';
import { WarehouseListItem } from '@admin/modules/warehouse/interfaces/WarehouseListItem';
import TableWithLoadingSkeleton from '@admin/common/components/tableList/TableWithLoadingSkeleton';
import TableToolbar from '@admin/common/components/tableList/TableToolbar';
import TableToolbarActions from '@admin/common/components/tableList/toolbar/TableToolbarActions';
import TableToolbarFilters from '@admin/common/components/tableList/toolbar/TableToolbarFilters';
import ActiveFilter from '@admin/common/components/tableList/filters/ActiveFilter';
import TableWrapper from '@admin/common/components/tableList/TableWrapper';
import TableHead from '@admin/common/components/tableList/TableHead';
import TableBody from '@admin/common/components/tableList/TableBody';
import { Pagination } from '@admin/common/interfaces/Pagination';
import TablePagination from '@admin/common/components/tableList/TablePagination';

const WarehouseList = () => {
  const { defaultFilters, defaultSort, getCurrentParam } = useListDefaultQueryParams();
  const [filters, setFilters] = useState<WarehouseTableFilters>(
    filterEmptyValues({
      ...defaultFilters,
      isActive: getCurrentParam('isActive', (value) => Boolean(value)),
    }) as WarehouseTableFilters,
  );

  const { items, pagination, isLoading, sort, setSort, removeItem } = useListData<WarehouseListItem, WarehouseTableFilters>({
    endpoint: 'admin/warehouses',
    filters,
    setFilters,
    defaultSort,
  });

  const rowData = items.map((item: WarehouseListItem) => [
      <TableRowId id={item.id} />,
      item.name,
      item.fullAddress,
      <TableRowActive isActive={item.isActive} />,
      <TableActions id={item.id} onDelete={() => removeItem(`admin/warehouses/${item.id}`)} />,
  ]);


  const columns: TableColumn[] = [
    { orderBy: 'id', label: 'ID', sortable: true },
    { orderBy: 'name', label: 'Nazwa', sortable: true },
    { orderBy: 'fullAddress', label: 'Adres'},
    { orderBy: 'isActive', label: 'Aktywny', sortable: true},
    { orderBy: 'actions', label: 'Actions' },
  ];


    return (
        <TableWithLoadingSkeleton isLoading={isLoading} filtersLimit={filters.limit}>
            <TableToolbar>
                <TableToolbarActions title="Lista magazynów" totalItems={pagination?.totalItems} />
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
        </TableWithLoadingSkeleton>

    );
}

export default WarehouseList;
