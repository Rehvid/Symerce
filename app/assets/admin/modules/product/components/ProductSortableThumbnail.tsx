import {
  useSortable,
} from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';
import DropzoneThumbnail from '@admin/components/form/dropzone/DropzoneThumbnail';
import SortableIcon from '@/images/icons/grip-vertical.svg';
import PhotoIcon from '@/images/icons/photos.svg'

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
      className={` transition-all duration-200 ease-in-out relative
      ${transform ? 'opacity-50' : ''}
    `}
    >

      <DropzoneThumbnail
        file={file}
        removeFile={removeFile}
        isMainThumbnail={isMainThumbnail}
        variant="multiple"
      >
        <div
          {...listeners}
          className="cursor-grab"
        >
          <SortableIcon className="text-white w-[30px] h-[30px] mx-auto" />
        </div>
      <span
        className="block cursor-pointer"
        onClick={() => setMainThumbnail(file)}
      >
         <PhotoIcon className="text-white w-[30px] h-[30px] mx-auto" />
      </span>

      </DropzoneThumbnail>
    </div>
  );
};

export default ProductSortableThumbnail;
