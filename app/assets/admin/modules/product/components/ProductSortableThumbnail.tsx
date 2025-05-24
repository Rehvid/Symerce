import {
  useSortable,
} from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';
import DropzoneThumbnail from '@admin/components/form/dropzone/DropzoneThumbnail';
import PhotoIcon from '@/images/icons/photos.svg';

const ProductSortableThumbnail = ({ file, removeFile, setMainThumbnail, isMainThumbnail }) => {
  const {
    attributes,
    listeners,
    setNodeRef,
    transform,
    transition
  } = useSortable({ id: file.uuid });

  const style = {
    transform: CSS.Transform.toString(transform),
    transition,
  };

  return (
    <div
      ref={setNodeRef}
      style={style}
      {...attributes}
      className={`
      rounded-md bg-white shadow-sm
      transition-all duration-200 ease-in-out
      ${transform ? 'ring-2 ring-primary/50 opacity-80' : ''}
    `}
    >
      <div
        {...listeners}
        className="cursor-grab p-2 text-center"
        title="Przeciągnij, aby zmienić kolejność"
      >
        <PhotoIcon className="text-gray-400 w-5 h-5 mx-auto" />
      </div>

      <DropzoneThumbnail
        file={file}
        removeFile={removeFile}
        isMainThumbnail={isMainThumbnail}
        variant="multiple"
      >
      <span
        className="block cursor-pointer"
        onClick={() => setMainThumbnail(file)}
      >
        <PhotoIcon className="text-white w-[30px] h-[30px]" />
      </span>
      </DropzoneThumbnail>
    </div>
  );
};

export default ProductSortableThumbnail;
