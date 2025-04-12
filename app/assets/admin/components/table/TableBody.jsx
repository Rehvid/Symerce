import { useRef, useState } from 'react';

const TableBody = ({ data, useDraggable, draggableCallback }) => {
    const [items, setItems] = useState(data);
    const dragItem = useRef();
    const dragOverItem = useRef();

    const dragStart = (e) => {
        dragItem.current = e.target.id;
    };
    const dragEnter = (e) => {
        dragOverItem.current = e.currentTarget.id;
    };

    const drop = () => {
        const copyListItems = [...data];
        const currentDragItem = copyListItems[dragItem.current];
        copyListItems.splice(dragItem.current, 1);
        copyListItems.splice(dragOverItem.current, 0, currentDragItem);

        setItems(copyListItems);
        draggableCallback?.(copyListItems);
    };

    return (
        <tbody>
            {items.map((row, rowIndex) => {
                return useDraggable ? (
                    <tr
                        onDragStart={(e) => dragStart(e)}
                        onDragEnter={(e) => dragEnter(e)}
                        onDragEnd={drop}
                        draggable
                        key={rowIndex}
                        id={rowIndex}
                        className="border-b border-gray-100 last:border-b-0"
                    >
                        {row.map((cell, cellIndex) => (
                            <td key={cellIndex} className="px-4 py-3 font-normal text-sm whitespace-nowrap">
                                {cell}
                            </td>
                        ))}
                    </tr>
                ) : (
                    <tr key={rowIndex} id={rowIndex} className="border-b border-gray-100 last:border-b-0">
                        {row.map((cell, cellIndex) => (
                            <td key={cellIndex} className="px-4 py-3 font-normal text-sm whitespace-nowrap">
                                {cell}
                            </td>
                        ))}
                    </tr>
                );
            })}
        </tbody>
    );
};

export default TableBody;
