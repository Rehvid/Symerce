import React, { Fragment, useEffect, useRef, useState } from 'react';
import { isOnlyPaginationInDataTable } from '@admin/common/utils/helper';
import { Pagination } from '@admin/common/interfaces/Pagination';
import clsx from 'clsx';
import { TableFilters } from '@admin/common/interfaces/TableFilters';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import SuspenseFallback from '@admin/pages/SuspenseFallback';
import { DraggableItem } from '@admin/common/types/draggableItem';


interface TableBodyProps<T, F extends TableFilters> {
    data: T[],
    useDraggable?: boolean,
    draggableCallback?: (info: DraggableItem) => void;
    pagination: Pagination,
    filters: F
}

const TableBody = <T, F extends TableFilters>({
    data,
    useDraggable = false,
    draggableCallback,
    pagination,
    filters,
}: TableBodyProps<T, F>) => {
    const [items, setItems] = useState(data);
    const [draggedItemIndex, setDraggedItemIndex] = useState<number | null>(null);
    const [dragOverItemIndex, setDragOverItemIndex] = useState<number | null>(null);
    const prevDataRef = useRef(data);

    const isDraggableEnabled = useDraggable && isOnlyPaginationInDataTable(filters);


    const extractRowId = (row: any): string | number | null => {
        const cells = Array.isArray(row) ? row : Object.values(row);
        return cells.find((cell) => cell?.props?.id)?.props?.id ?? null;
    };

    useEffect(() => {
        const prevIds = prevDataRef.current.map(extractRowId);
        const currentIds = data.map(extractRowId);

        const isSame = prevIds.length === currentIds.length && prevIds.every((id, i) => id === currentIds[i]);

        if (!isSame) {
            setItems(data);
        }

        prevDataRef.current = data;
    }, [data]);

    const dragStart = (e: React.DragEvent<HTMLTableRowElement>, index: number) => {
        setDraggedItemIndex(index);
        e.currentTarget.classList.add('dragging');
    };

    const dragEnter = (_: React.DragEvent<HTMLTableRowElement>, index: number) => {
        setDragOverItemIndex(index);
    };

    const drop = () => {
        if (draggedItemIndex === null || dragOverItemIndex === null || draggedItemIndex === dragOverItemIndex) {
            cleanup();
            return;
        }

        const reordered = [...items];
        const [movedItem] = reordered.splice(draggedItemIndex, 1);
        reordered.splice(dragOverItemIndex, 0, movedItem);
        setItems(reordered);

        const movedId = extractRowId(movedItem);
        if (!movedId) {
            console.error('Cannot find movedId!');
            cleanup();
            return;
        }

        const { page = 1, limit = 10 } = pagination;
        draggableCallback?.({
            movedId,
            oldPosition: (page - 1) * limit + draggedItemIndex,
            newPosition: (page - 1) * limit + dragOverItemIndex,
        });

        cleanup();
    };

    const cleanup = () => {
        setDraggedItemIndex(null);
        setDragOverItemIndex(null);
        document.querySelectorAll('.dragging').forEach((el) => el.classList.remove('dragging'));
    };

    const renderPlaceholder = (index: number) => (
        <tr key={`placeholder-${index}`} className="transition-all duration-150 ease-in-out">
            <td colSpan={100}>
                <div className="h-2 bg-primary rounded-md my-2 animate-pulse" />
            </td>
        </tr>
    );

    const renderCells = (row: any, isLastRow: boolean) => {
        const cells = Array.isArray(row) ? row : Object.values(row);

        return cells.map((cell, i) => (
            <td
                key={i}
                className={clsx(
                    'px-2 py-3 font-normal text-sm whitespace-nowrap border-t border-gray-100',
                    isLastRow && i === 0 && 'rounded-bl-xl',
                    isLastRow && i === cells.length - 1 && 'rounded-br-xl'
                )}
            >
                {cell}
            </td>
        ));
    };

    const hasItems = items.length > 0;

    return (
        <tbody className="relative">
        {useDraggable && !isDraggableEnabled && hasItems && (
            <tr>
                <td colSpan={100} className="text-center p-2 text-gray-400 text-sm italic">
                    Przeciąganie wyłączone przy aktywnych filtrach lub sortowaniu
                </td>
            </tr>
        )}

        {hasItems ? (
            items.map((row, index) => {
                const isLastRow = index === items.length - 1;
                const isDragging = index === draggedItemIndex;

                const rowClass = clsx(
                    'bg-white border-t border-gray-100 transition-all duration-150 ease-in-out',
                    isDraggableEnabled && 'hover:cursor-grab',
                    isDragging && 'opacity-50 scale-[1.01] bg-slate-100'
                );

                return (
                    <Fragment key={`row-${index}`}>
                        {isDraggableEnabled && dragOverItemIndex === index && renderPlaceholder(index)}

                        <tr
                            draggable={isDraggableEnabled}
                            onDragStart={(e) => dragStart(e, index)}
                            onDragEnter={(e) => dragEnter(e, index)}
                            onDragOver={(e) => e.preventDefault()}
                            onDragEnd={drop}
                            id={String(index)}
                            className={rowClass}
                        >
                            {renderCells(row, isLastRow)}
                        </tr>
                    </Fragment>
                );
            })
        ) : (
            <tr>
                <td colSpan={100} className="text-center p-5 text-gray-500 text-md font-bold">
                    Brak danych
                </td>
            </tr>
        )}
        </tbody>
    );
};

export default TableBody;
