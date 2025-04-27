import DropzonePreviewActions from '@/admin/components/form/dropzone/DropzonePreviewActions';

const DropzonePreview = ({ renderModal, removeFile, file, additionalClasses = '', children }) => {
    return (
        <div
            className={`${additionalClasses} absolute transition-all w-full h-full inset-0 flex items-center justify-center gap-3 opacity-0 hover:bg-black/40 hover:opacity-100`}
        >
            {children}
            <DropzonePreviewActions renderModal={renderModal} removeFile={removeFile} file={file} />
        </div>
    );
};

export default DropzonePreview;
