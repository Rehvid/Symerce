import DropzonePreview from '@/admin/components/form/dropzone/DropzonePreview';
import ModalFile from '@admin/common/components/modal/ModalFile';

const DropzoneThumbnail = ({ file, removeFile, index, variant, isMainThumbnail, children }) => {
    const variants = {
        avatar: 'absolute flex top-0 h-40 w-40 rounded-full',
        single: 'absolute flex top-0 rounded-lg w-full h-full border border-gray-200',
        multiple: `relative flex sm:h-48 sm:w-48 max-w-lg w-full h-auto rounded-lg border border-gray-100`,
    };

    const roundedClasses = `${variant === 'avatar' ? 'rounded-full' : 'rounded-lg'}`;

    return (
        <div className={`${variants[variant]}`} key={index}>
          {variant === 'multiple' ? (
            <div className="relative">
              <img
                className={`${roundedClasses} mx-auto object-cover w-full h-full`}
                src={file.preview}
                alt={file.name}
              />
              {isMainThumbnail && (
                <div className="absolute bg-black/40 opacity-100 inset-x-0 bottom-0 p-4 text-white text-center font-medium tracking-wide uppercase">Miniaturka</div>
              )}
            </div>
          ) : (
            <img
              className={`${roundedClasses} mx-auto object-cover w-full`}
              src={file.preview}
              alt={file.name}
            />
          )}

            <DropzonePreview
                renderModal={() => <ModalFile preview={file.preview} name={file.name} />}
                removeFile={removeFile}
                file={file}
                additionalClasses={roundedClasses}
            >
                {children}
            </DropzonePreview>
        </div>
    );
};

export default DropzoneThumbnail;
