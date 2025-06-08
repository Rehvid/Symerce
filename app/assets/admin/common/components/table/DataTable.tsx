import React from 'react';
import { TableColumn } from '@admin/common/types/tableColumn';
import { Pagination } from '@admin/common/interfaces/Pagination';
import { Sort } from '@admin/common/interfaces/Sort';
import Table from '@admin/common/components/table/Table';
import TablePagination from '@admin/common/components/tableList/TablePagination';

export interface DataTableProps<T, F extends Record<string, any>> {
  filters: F,
  setFilters: React.Dispatch<React.SetStateAction<F>>,
  defaultFilters: F,
  additionalFilters?: JSX.Element[],
  additionalToolbarContent?: React.ReactNode;
  columns: TableColumn[],
  items: T[],
  pagination: Pagination,
  useDraggable?: boolean,
  draggableCallback?: (items: T[]) => void;
  sort: Sort,
  setSort: React.Disptach<React.SetStateAction<Sort>>,
}

const DataTable: React.FC<DataTableProps> = ({
  filters,
  setFilters,
  defaultFilters,
  additionalFilters,
  additionalToolbarContent,
  columns,
  items,
  pagination,
  useDraggable,
  draggableCallback,
  sort,
  setSort,
}) => (
  <Table
    filters={filters}
    setFilters={setFilters}
    defaultFilters={defaultFilters}
    additionalFilters={additionalFilters}
    columns={columns}
    additionalToolbarContent={additionalToolbarContent}
    items={items}
    useDraggable={useDraggable}
    draggableCallback={draggableCallback}
    sort={sort}
    setSort={setSort}
    pagination={pagination}
  >
    {/*<TablePagination filters={filters} setFilters={setFilters} pagination={pagination} />*/}
  </Table>
)

export default DataTable;
