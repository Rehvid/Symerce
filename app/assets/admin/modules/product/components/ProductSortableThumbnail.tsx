import {
  useSortable,
} from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';
import DropzoneThumbnail from '@admin/components/form/dropzone/DropzoneThumbnail';
import PhotoIcon from '@/images/icons/photos.svg';
import DropzonePreview from '@admin/components/form/dropzone/DropzonePreview';

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
    <div ref={setNodeRef} style={style} {...attributes}>
      {/* Drag handle - tu łapiesz tylko drag */}
      <div {...listeners} className="cursor-grab p-1">
        {/* Możesz tu dodać ikonę "przesuń" lub cały thumbnail, jeśli chcesz */}
        <PhotoIcon className="text-gray-400" />
      </div>

      {/* Reszta komponentu bez listeners - tutaj działa kliknięcie */}
      <DropzoneThumbnail
        file={file}
        removeFile={removeFile}
        isMainThumbnail={isMainThumbnail}
        variant="multiple"
      >
        <DropzonePreview
          renderModal={() => <ModalFile preview={file.preview} name={file.name} />}
          removeFile={removeFile}
          file={file}
          additionalClasses="rounded-lg"
        >
          {/* Twoje children (np. ikona do ustawiania miniatury) */}
          <span
            className="block cursor-pointer"
            onClick={() => setMainThumbnail(file)}
          >
            <PhotoIcon className="text-white scale-125%" />
          </span>
        </DropzonePreview>
      </DropzoneThumbnail>
    </div>
  );
};

export default ProductSortableThumbnail;
