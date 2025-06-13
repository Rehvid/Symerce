import React, { FC } from 'react';
import { TableColumn } from '@admin/common/types/tableColumn';
import { Sort } from '@admin/common/interfaces/Sort';
import { SortDirection } from '@admin/common/enums/sortDirection';
import clsx from 'clsx';
import SortAscendingIcon from '@/images/icons/sort-ascending.svg';
import SortDescendingIcon from '@/images/icons/sort-descending.svg';

interface TableHeadProps {
    columns: TableColumn[];
    sort: Sort;
    setSort: React.Dispatch<React.SetStateAction<Sort>>;
}

const TableHead: FC<TableHeadProps> = ({ columns, sort, setSort }) => {
    const handleSort = (orderBy: string) => {
        if (sort.orderBy === orderBy) {
            const newDirection = sort.direction === SortDirection.ASC ? SortDirection.DESC : SortDirection.ASC;

            setSort({
                orderBy,
                direction: newDirection,
            });
        } else {
            setSort({
                orderBy,
                direction: SortDirection.ASC,
            });
        }
    };

    const renderSortIcon = (sortable: boolean | undefined, orderBy: string) => {
        if (!sortable) {
            return null;
        }

        const isActive = sort.orderBy === orderBy;

        if (!isActive) {
            return <SortAscendingIcon className="w-[20px] h-[20px] text-gray-300" />;
        }

        const Icon = sort.direction === SortDirection.ASC ? SortAscendingIcon : SortDescendingIcon;

        return <Icon className="w-[20px] h-[20px] text-black" />;
    };

    return (
        <thead>
            <tr>
                {columns.map(({ label, orderBy, sortable = false }, index) => (
                    <th
                        key={index}
                        className={clsx(
                            'px-2 py-3 bg-gray-100 text-gray-500',
                            index === 0 && 'rounded-tl-xl',
                            index === columns.length - 1 && 'rounded-tr-xl',
                        )}
                        scope="col"
                    >
                        <div
                            className={clsx('flex items-center gap-1', sortable && 'cursor-pointer')}
                            onClick={sortable ? () => handleSort(orderBy) : undefined}
                        >
                            <p className="font-medium text-sm text-gray-700">{label}</p>
                            {renderSortIcon(sortable, orderBy)}
                        </div>
                    </th>
                ))}
            </tr>
        </thead>
    );
};

export default TableHead;
