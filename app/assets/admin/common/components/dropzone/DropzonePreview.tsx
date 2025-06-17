import DropzonePreviewActions from '@admin/common/components/dropzone/DropzonePreviewActions';
import React, { ReactNode, useState } from 'react';
import clsx from 'clsx';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

type DropzonePreviewProps = {
    removeFile: (file: UploadFile) => void;
    file: UploadFile;
    additionalClasses?: string;
    children?: ReactNode;
};

const DropzonePreview: React.FC<DropzonePreviewProps> = ({ removeFile, file, additionalClasses = '', children }) => {
    const [showActions, setShowActions] = useState(false);

    const toggleActions = () => setShowActions((prev) => !prev);

    const containerClasses = clsx(
        'absolute inset-0 w-full h-full flex flex-wrap gap-2 p-2 items-center cursor-pointer transition-all',
        showActions ? 'bg-black/80 opacity-100' : 'opacity-0',
        additionalClasses,
    );

    return (
        <div className={containerClasses} onClick={toggleActions}>
            {children}

            {showActions && <DropzonePreviewActions removeFile={removeFile} file={file} />}
        </div>
    );
};
export default DropzonePreview;
