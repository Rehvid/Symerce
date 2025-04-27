import SortAscendingIcon from '@/images/icons/sort-ascending.svg';
import SortDescendingIcon from '@/images/icons/sort-descending.svg';
import { SORT_DIRECTION } from '@/admin/constants/sortDirectionConstants';

const TableColumns = ({ columns, sort, setSort }) => {
    const handleSort = (orderBy) => {
      setSort((prev) => {
        if (prev.orderBy === orderBy) {
          return {
            orderBy,
            direction: prev.direction === SORT_DIRECTION.ASC ? SORT_DIRECTION.DESC : SORT_DIRECTION.ASC,
          };
        } else {
          return {
            orderBy,
            direction: SORT_DIRECTION.DESC,
          };
        }
      });
    }

    return (
        <thead className="bg-gray-50 border-b border-gray-100">
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
                        {sortable && (
                          sort.orderBy === orderBy ? (
                            sort.direction === SORT_DIRECTION.ASC ? (
                              <SortAscendingIcon className="scale-75 text-black " />
                            ) : (
                              <SortDescendingIcon className="scale-75 text-black" />
                            )
                          ) : (
                            <SortAscendingIcon className="scale-75 text-gray-400" />
                          )
                        )}
                      </div>
                    </th>
                  )
                })}
            </tr>
        </thead>
    );
};

export default TableColumns;
