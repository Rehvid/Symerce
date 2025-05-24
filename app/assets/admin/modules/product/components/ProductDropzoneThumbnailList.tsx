import ProductSortableThumbnail from '@admin/modules/product/components/ProductSortableThumbnail';
import { useSensors, useSensor, PointerSensor, DndContext, closestCenter } from '@dnd-kit/core';
import { arrayMove, SortableContext, verticalListSortingStrategy } from '@dnd-kit/sortable';


const ProductDropzoneThumbnailList = ({ files, setFiles, setMainThumbnail }) => {
  const sensors = useSensors(useSensor(PointerSensor));

  const handleDragEnd = (event) => {
    const { active, over } = event;

    if (active.id !== over.id) {
      setFiles(prev => {
        const oldIndex = prev.findIndex(file => file.uuid === active.id);
        const newIndex = prev.findIndex(file => file.uuid === over.id);
        const newFiles = arrayMove(prev, oldIndex, newIndex);

        return newFiles.map((file) => ({
          ...file,
        }));
      });
    }
  };

  return (
    <DndContext sensors={sensors} collisionDetection={closestCenter} onDragEnd={handleDragEnd}>
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
    </DndContext>
  );
};

export default ProductDropzoneThumbnailList;
