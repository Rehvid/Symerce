import DropzonePreview from '@/admin/components/form/dropzone/DropzonePreview';
import ModalFile from '@/admin/components/modal/ModalFile';

const DropzoneThumbnail = ({ file, removeFile, index, variant, isMainThumbnail, children }) => {
    const variants = {
        avatar: 'absolute flex top-0 h-40 w-40 rounded-full',
        single: 'absolute flex top-0 rounded-lg w-full h-full border border-gray-200',
        multiple: `relative flex sm:h-40 sm:w-40 max-w-lg w-full h-auto rounded-lg border p-2  ${isMainThumbnail ? 'border-primary border-2' : 'border-gray-200'}`,
    };

    const roundedClasses = `${variant === 'avatar' ? 'rounded-full' : 'rounded-lg'}`;

    return (
        <div className={`${variants[variant]}`} key={index}>
            <img className={`${roundedClasses} mx-auto object-cover w-full`} src={file.preview} alt={file.name} />
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
