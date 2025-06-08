import TableToolbar from '@admin/common/components/table/TableToolbar';
import TableColumns from '@admin/common/components/table/TableColumns';
import TableBody from '@admin/common/components/tableList/TableBody';
import { DataTableProps } from '@admin/common/components/table/DataTable';
import React from 'react';

interface TableProps extends DataTableProps<T, F> {
  children: React.ReactNode
}

const Table: React.FC<TableProps> = ({
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
  children,
}) => (
  <div className="my-6">
    <div className="p-6 space-y-6">
      <TableToolbar
        filters={filters}
        setFilters={setFilters}
        additionalFilters={additionalFilters}
        additionalToolbarContent={additionalToolbarContent}
        sort={sort}
        setSort={setSort}
        defaultFilters={defaultFilters}
      />
      <div className="overflow-auto mb-0">
        <table className="data-table table space-y-6 w-full border-separate border-spacing-y-4">
          <TableColumns columns={columns} sort={sort} setSort={setSort} />
          <TableBody<T, F>
            data={items}
            useDraggable={useDraggable}
            draggableCallback={draggableCallback}
            pagination={pagination}
            filters={filters}
          />
        </table>
      </div>
      {children && children}
    </div>
  </div>
)

export default Table;
