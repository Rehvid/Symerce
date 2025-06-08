import { TableColumn } from '@admin/common/types/tableColumn';
import { Sort } from '@admin/common/interfaces/Sort';
import React from 'react';
import { SortDirection } from '@admin/common/enums/sortDirection';
import SortAscendingIcon from '@/images/icons/sort-ascending.svg';
import SortDescendingIcon from '@/images/icons/sort-descending.svg';

interface TableColumnsProps {
  columns: TableColumn[];
  sort: Sort,
  setSort: React.Dispatch<React.SetStateAction<Sort>>
}

const TableColumns: React.FC<TableColumnsProps> = ({
  columns,
  sort,
  setSort
}) => {
  const handleSort = (orderBy: string) => {
    setSort((prev) => {
      if (prev.orderBy === orderBy) {
        return {
          orderBy,
          direction: prev.direction === SortDirection.ASC ? SortDirection.DESC : SortDirection.ASC,
        };
      } else {
        return {
          orderBy,
          direction: SortDirection.DESC,
        };
      }
    });
  };

  const renderSortIcon = (sortable: boolean | undefined, orderBy: string) => {
    if (!sortable) {
      return null;
    }

    if (sort.orderBy !== orderBy) {
      return <SortAscendingIcon className="w-[20px] h-[20px] text-gray-400" />;
    }

    return sort.direction === SortDirection.ASC ? (
      <SortAscendingIcon className="w-[20px] h-[20px] text-primary" />
    ) : (
      <SortDescendingIcon className="w-[20px] h-[20px] text-primary" />
    );
  };

  return (
    <thead>
    <tr>
      {columns.map((col, index) => {
        const { label, orderBy, sortable = false } = col;
        return (
          <th key={index} className="px-4 py-3" scope="col">
            <div
              className={`flex items-center gap-1 ${sortable ? 'cursor-pointer' : ''}`}
              onClick={sortable ? () => handleSort(orderBy) : undefined}
            >
              <p className="font-medium text-sm text-black">{label}</p>
              {renderSortIcon(sortable, orderBy)}
            </div>
          </th>
        );
      })}
    </tr>
    </thead>
  );
}

export default TableColumns;
