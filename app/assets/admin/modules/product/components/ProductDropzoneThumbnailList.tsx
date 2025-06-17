import ProductSortableThumbnail from '@admin/modules/product/components/ProductSortableThumbnail';
import { useSensors, useSensor, PointerSensor, DndContext, closestCenter, DragOverlay } from '@dnd-kit/core';
import { arrayMove, SortableContext, verticalListSortingStrategy } from '@dnd-kit/sortable';
import { useState } from 'react';

const ProductDropzoneThumbnailList = ({ files, setFiles, setMainThumbnail, removeFile }) => {
    const sensors = useSensors(useSensor(PointerSensor));
    const [activeId, setActiveId] = useState(null);

    const handleDragEnd = (event) => {
        const { active, over } = event;

        if (active.id !== over.id) {
            setFiles((prev) => {
                const oldIndex = prev.findIndex((file) => file.uuid === active.id);
                const newIndex = prev.findIndex((file) => file.uuid === over.id);
                return arrayMove(prev, oldIndex, newIndex);
            });
        }
    };

    const activeFile = files.find((file) => file.uuid === activeId);

    return (
        <DndContext
            sensors={sensors}
            collisionDetection={closestCenter}
            onDragStart={(event) => setActiveId(event.active.id)}
            onDragEnd={handleDragEnd}
        >
            <SortableContext items={files.map((f) => f.uuid)} strategy={verticalListSortingStrategy}>
                    {files.map((file) => (
                        <ProductSortableThumbnail
                            key={file.uuid}
                            file={file}
                            removeFile={removeFile}
                            setMainThumbnail={setMainThumbnail}
                            isMainThumbnail={file.isThumbnail}
                        />
                    ))}
            </SortableContext>

            <DragOverlay>
                {activeFile ? (
                    <div className="rounded-lg border border-gray-300 bg-white shadow-md w-full h-full">
                        <img
                            className={`rounded-lg mx-auto object-cover w-full h-full`}
                            src={activeFile.preview}
                            alt={activeFile.name}
                        />
                    </div>
                ) : null}
            </DragOverlay>
        </DndContext>
    );
};

export default ProductDropzoneThumbnailList;
