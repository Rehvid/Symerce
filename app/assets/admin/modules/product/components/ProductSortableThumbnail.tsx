import { useSortable } from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';
import DropzoneThumbnail from '@admin/common/components/dropzone/DropzoneThumbnail';
import SortableIcon from '@/images/icons/grip-vertical.svg';
import PhotoIcon from '@/images/icons/photos.svg';
import { DropzoneVariant } from '@admin/common/components/dropzone/Dropzone';
import { ProductImage } from '@admin/modules/product/interfaces/ProductFormData';
import { FC } from 'react';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

interface ProductSortableThumbnailProps {
    file: ProductImage;
    removeFile: (file: UploadFile) => void;
    setMainThumbnail: (file: ProductImage) => void;
    isMainThumbnail: boolean;
}

const ProductSortableThumbnail: FC<ProductSortableThumbnailProps> = ({ file, removeFile, setMainThumbnail, isMainThumbnail }) => {
    const { attributes, listeners, setNodeRef, transform, transition } = useSortable({ id: file?.uuid ?? '' });

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
                variant={DropzoneVariant.Multiple}
            >
                <div {...listeners} className="cursor-grab">
                    <SortableIcon className="text-white w-[30px] h-[30px] mx-auto" />
                </div>
                <span className="block cursor-pointer" onClick={() => setMainThumbnail(file)}>
                    <PhotoIcon className="text-white w-[30px] h-[30px] mx-auto" />
                </span>
            </DropzoneThumbnail>
        </div>
    );
};

export default ProductSortableThumbnail;
