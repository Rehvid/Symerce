import ProductSortableThumbnail from '@admin/modules/product/components/ProductSortableThumbnail';
import PhotoIcon from '@/images/icons/photos.svg';
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
      <SortableContext items={files.map(f => f.uuid)} strategy={verticalListSortingStrategy}>
        <div className="flex flex-wrap gap-4">
          {files.map((file) => (
            <ProductSortableThumbnail
              key={file.uuid}
              file={file}
              removeFile={() => setFiles(prev => prev.filter(f => f.uuid !== file.uuid))}
              setMainThumbnail={setMainThumbnail}
              isMainThumbnail={file.isThumbnail}
            />
          ))}
        </div>
      </SortableContext>

      <DragOverlay>
        {activeFile ? (
          <div className="w-24 h-24 rounded-md border border-gray-300 bg-white flex items-center justify-center shadow-md">
            <PhotoIcon className="text-gray-400 w-8 h-8" />
          </div>
        ) : null}
      </DragOverlay>
    </DndContext>
  );
};

export default ProductDropzoneThumbnailList;
