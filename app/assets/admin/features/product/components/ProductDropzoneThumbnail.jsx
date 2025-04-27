import PhotoIcon from '@/images/icons/photos.svg';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';

const ProductDropzoneThumbnail = ({ file, removeFile, setMainThumbnail, index, thumbnail }) => {
    const isThumbnail = thumbnail === null ? file?.isThumbnail : thumbnail === file;

    return (
        <DropzoneThumbnail
            file={file}
            removeFile={removeFile}
            isMainThumbnail={isThumbnail}
            variant="multiple"
            index={index}
        >
            <span
                className="block cursor-pointer"
                onClick={() => {
                    setMainThumbnail(file);
                }}
            >
                <PhotoIcon className="text-white scale-125%" />
            </span>
        </DropzoneThumbnail>
    );
};

export default ProductDropzoneThumbnail;
