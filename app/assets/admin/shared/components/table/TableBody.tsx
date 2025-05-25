import React, { Fragment, useEffect, useRef, useState } from 'react';
import { isOnlyPaginationInDataTable } from '@/admin/utils/helper';
import { PaginationMetaInterface } from '@admin/shared/interfaces/PaginationMetaInterface';

interface TableBodyProps<T, F extends Record<string, any>> {
  data: T[],
  useDraggable?: boolean,
  draggableCallback?: (items: T[]) => void,
  pagination: PaginationMetaInterface,
  filters: F
}

const TableBody: React.FC<TableBodyProps> = ({
 data,
 useDraggable,
 draggableCallback,
 pagination,
 filters
}) => {
  const [items, setItems] = useState(data);
  const [draggedItemIndex, setDraggedItemIndex] = useState<number | null>(null);
  const [dragOverItemIndex, setDragOverItemIndex] = useState<number | null>(null);

  const prevDataRef = useRef(data);

  const getIds = (list: Array<any>): Array<string | number | undefined> =>
    list.map((row) =>
      Array.isArray(row)
        ? row.map((cell) => cell?.props?.id).find((id) => id !== undefined)
        : Object.values(row)
          .map((cell) => cell?.props?.id)
          .find((id) => id !== undefined),
    );

  useEffect(() => {
    const prevData = prevDataRef.current;
    const prevIds = getIds(prevData);
    const currentIds = getIds(data);

    const isSameIds =
      prevIds.length === currentIds.length
      && prevIds.every((id, index) => id === currentIds[index]);

    if (!isSameIds) {
      setItems(data);
    }

    prevDataRef.current = data;
  }, [data]);

  const dragStart = (e: React.DragEvent<HTMLTableRowElement>, index: number) => {
    setDraggedItemIndex(index);
    e.currentTarget.classList.add('dragging');
  };

  const dragEnter = (e: React.DragEvent<HTMLTableRowElement>, index: number) => {
    setDragOverItemIndex(index);
  };

  const drop = () => {
    if (draggedItemIndex === null || dragOverItemIndex === null) {
      return;
    }

    const copyListItems = [...items];
    if (draggedItemIndex === dragOverItemIndex) {
      cleanup();
      return;
    }

    const currentDragItem = copyListItems[draggedItemIndex];
    copyListItems.splice(draggedItemIndex, 1);
    copyListItems.splice(dragOverItemIndex, 0, currentDragItem);

    setItems(copyListItems);

    const findId = (item: any[]): string | number | null => {
      let foundId: string | null | number = null;
      item.some((element) => {
        if (element.props?.id) {
          foundId = element.props.id;
          return true;
        }
        return false;
      });
      return foundId;
    };

    const movedId = findId(currentDragItem);

    if (!movedId) {
      console.error('Cannot find movedId!');
      return;
    }

    const page = pagination?.page ?? 1;
    const pageSize = pagination?.limit ?? 10;

    const oldPosition = (page - 1) * pageSize + draggedItemIndex;
    const newPosition = (page - 1) * pageSize + dragOverItemIndex;

    draggableCallback?.({
      movedId,
      oldPosition,
      newPosition,
    });

    cleanup();
  };

  const cleanup = () => {
    setDraggedItemIndex(null);
    setDragOverItemIndex(null);
    document.querySelectorAll('.dragging').forEach((el) => el.classList.remove('dragging'));
  };

  const renderCells = (row: any) => {
    const cells = Array.isArray(row) ? row : Object.values(row);
    return cells.map((cell, cellIndex) => (
      <td key={cellIndex} className="px-4 py-6 font-normal text-sm whitespace-nowrap">
        {cell}
      </td>
    ));
  };

  const renderPlaceholder = (index: number) => (
    <tr key={`placeholder-${index}`} className="transition-all duration-150 ease-in-out">
      <td colSpan="100%">
        <div className="h-2 bg-primary rounded-md my-2 animate-pulse" />
      </td>
    </tr>
  );

  const isDraggableEnabled = useDraggable && isOnlyPaginationInDataTable(filters);

  return (
    <tbody>
    {useDraggable && !isDraggableEnabled && (
      <tr className="">
        <td colSpan="100%" className="text-center p-2 text-gray-400 text-sm italic">
          Przeciąganie wyłączone przy aktywnych filtrach lub sortowaniu
        </td>
      </tr>
    )}

    {items.length > 0 ? (
      items.map((row, rowIndex) => {
        const isDragging = draggedItemIndex === rowIndex;
        const rowClasses = `shadow bg-white transition-all duration-150 ease-in-out hover:cursor-grab ${
          isDragging ? 'opacity-50 scale-[1.01] bg-slate-100' : ''
        }`;
        return (
          <Fragment key={`row-wrapper-${rowIndex}`}>
            {useDraggable && dragOverItemIndex === rowIndex && renderPlaceholder(rowIndex)}

            {useDraggable && isDraggableEnabled ? (
              <tr
                onDragStart={(e) => dragStart(e, rowIndex)}
                onDragEnter={(e) => dragEnter(e, rowIndex)}
                onDragOver={(e) => e.preventDefault()}
                onDragEnd={drop}
                draggable
                key={rowIndex}
                id={rowIndex}
                className={rowClasses}
              >
                {renderCells(row)}
              </tr>
            ) : (
              <tr key={rowIndex} id={rowIndex} className="shadow bg-white">
                {renderCells(row)}
              </tr>
            )}
          </Fragment>
        );
      })
    ) : (
      <tr>
        <td colSpan="100%" className="text-center p-5 text-gray-500 text-md font-bold">
          Brak danych
        </td>
      </tr>
    )}
    </tbody>
  );
};

export default TableBody;
