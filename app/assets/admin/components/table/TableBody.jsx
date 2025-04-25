import { Fragment, useEffect, useState } from 'react';

const TableBody = ({ data, useDraggable, draggableCallback }) => {
  const [hasInitItems, setHasInitItems] = useState(false);
  const [items, setItems] = useState(data);
  const [draggedItemIndex, setDraggedItemIndex] = useState(null);
  const [dragOverItemIndex, setDragOverItemIndex] = useState(null);

    useEffect(() => {
        if (hasInitItems) {
          setHasInitItems(true);
          setItems(data);
        }
    }, [data]);

  const dragStart = (e, index) => {
    setDraggedItemIndex(index);
    e.currentTarget.classList.add("dragging");
  };

  const dragEnter = (e, index) => {
    setDragOverItemIndex(index);
  };

    const drop = () => {
      if (draggedItemIndex === null || dragOverItemIndex === null) return;

      const copyListItems = [...items];
      if (draggedItemIndex === dragOverItemIndex) {
        cleanup();
        return;
      }

      const currentDragItem = copyListItems[draggedItemIndex];
      copyListItems.splice(draggedItemIndex, 1);
      copyListItems.splice(dragOverItemIndex, 0, currentDragItem);

      setItems(copyListItems);

      document.querySelectorAll(".dragging").forEach(el => el.classList.remove("dragging"));

      const foundIds = copyListItems.map(item => {
            let foundId = null;
            item.some(element => {
                if (element.props?.id) {
                    foundId = element.props.id;
                    return true;
                }
                return false;
            });
            return foundId;
        }).filter(id => id !== null && id !== undefined);

        if (foundIds.length === 0 || foundIds.length !== copyListItems.length) {
            console.error("The resulting array is empty or identical to the original list.");
            return;
        }

        cleanup();
        draggableCallback?.(foundIds);
    };

  const cleanup = () => {
    setDraggedItemIndex(null);
    setDragOverItemIndex(null);
    document.querySelectorAll(".dragging").forEach(el => el.classList.remove("dragging"));
  };

    const renderCells = (row) => {
        const cells = Array.isArray(row) ? row : Object.values(row);
        return cells.map((cell, cellIndex) => (
            <td key={cellIndex} className="px-4 py-3 font-normal text-sm whitespace-nowrap text-center">
                {cell}
            </td>
        ));
    };

  const renderPlaceholder = (index) => (
    <tr key={`placeholder-${index}`} className="transition-all duration-150 ease-in-out">
      <td colSpan="100%">
        <div className="h-2 bg-primary rounded-md my-2 animate-pulse" />
      </td>
    </tr>
  );

    return (
        <tbody>
            {items.map((row, rowIndex) => {
              const isDragging = draggedItemIndex === rowIndex;
              const rowClasses = `border-b border-gray-100 last:border-b-0 transition-all duration-150 ease-in-out hover:cursor-grab ${
                isDragging ? 'opacity-50 scale-[1.01] bg-slate-100' : ''
              }`;
                return (
                  <Fragment  key={`row-wrapper-${rowIndex}`} >
                  {useDraggable && dragOverItemIndex === rowIndex && renderPlaceholder(rowIndex)}

                  {useDraggable ? (
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
                  <tr key={rowIndex} id={rowIndex} className="border-b border-gray-100 last:border-b-0">
                    {renderCells(row)}
                  </tr>
                  )}
                </Fragment>
                )
            })}
        </tbody>
    );
};

export default TableBody;
