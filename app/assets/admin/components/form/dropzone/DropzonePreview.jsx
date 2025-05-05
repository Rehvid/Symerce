import DropzonePreviewActions from '@/admin/components/form/dropzone/DropzonePreviewActions';
import { useState } from 'react';

const DropzonePreview = ({ renderModal, removeFile, file, additionalClasses = '', children }) => {
    const [showActions, setShowActions] = useState(false);

    const toggleActions = () => setShowActions((prev) => !prev);

    return (
        <div
            className={`
                ${additionalClasses} absolute transition-all w-full h-full inset-0 cursor-pointer
                flex items-center justify-center gap-3
                ${showActions ? 'bg-black/40 opacity-100' : 'opacity-0'}
            `}
            onClick={toggleActions}
        >
            {children}
            {showActions && <DropzonePreviewActions renderModal={renderModal} removeFile={removeFile} file={file} />}
        </div>
    );
};

export default DropzonePreview;
