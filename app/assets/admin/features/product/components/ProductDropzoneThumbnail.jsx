import PhotoIcon from '@/images/icons/photos.svg';
import DropzonePreviewActions from '@/admin/components/form/dropzone/DropzonePreviewActions';
import ModalFile from '@/admin/components/modal/ModalFile';

const ProductDropzoneThumbnail = ({file, removeFile, setMainThumbnail, index, thumbnail}) => {
  const isThumbnail = thumbnail === null ? file?.isThumbnail : thumbnail === file;

  return (
      <div
        className={`relative flex h-40 w-40 rounded-lg border p-2 ${isThumbnail ? 'border-primary border-2' : 'border-gray-200'} `}
        key={index}>
        <img
          className="rounded-lg mx-auto object-cover w-full"
          src={file.preview}
          alt={file.name}
        />
        <div
          className="absolute rounded-lg transition-all w-full h-full inset-0 flex items-center justify-center gap-3 opacity-0 hover:bg-black/40 hover:opacity-100">
                     <span
                       className="block cursor-pointer"
                       onClick={() => {
                         setMainThumbnail(file);
                       }}
                     >
                      <PhotoIcon className="text-white scale-125%" />
                  </span>
          <DropzonePreviewActions
            renderModal={() => <ModalFile preview={file.preview} name={file.name} />}
            removeFile={removeFile}
            file={file}
          />
        </div>
      </div>
    );
}

export default ProductDropzoneThumbnail;
