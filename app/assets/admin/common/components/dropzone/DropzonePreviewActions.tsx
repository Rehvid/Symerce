import EyeIcon from '@/images/icons/eye.svg';
import TrashIcon from '@/images/icons/trash.svg';
import React, { FC } from 'react';
import { PositionType } from '@admin/common/enums/positionType';
import DrawerHeader from '@admin/common/components/drawer/DrawerHeader';
import { useDrawer } from '@admin/common/components/drawer/DrawerContext';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

interface DropzonePreviewActionsProps {
    removeFile: (file: UploadFile) => void;
    file: UploadFile;
}

const DropzonePreviewActions: FC<DropzonePreviewActionsProps> = ({ removeFile, file }) => {
    const { open } = useDrawer();

    const handleRemove = () => {
        removeFile(file);
    };

    const fileDrawerContent = () => (
        <>
            <DrawerHeader>
                <div className="flex flex-col items-center gap-3">
                    <span>{file.name}</span>
                </div>
            </DrawerHeader>
            <div className="rounded-lg h-full overflow-auto p-2">
                <img className="rounded-lg h-auto max-w-2xl" src={file.preview} alt={file.name} />
            </div>
        </>
    );

    return (
        <>
            <span
                onClick={() => {
                    open('dropzonePreviewThumbnail', fileDrawerContent(), PositionType.CENTER);
                }}
                className="flex items-center w-12 h-12  cursor-pointer bg-gray-100 hover:bg-primary text-gray-500 hover:text-white transition-colors rounded-full p-2 duration-300"
            >
                <EyeIcon className="w-8 h-8" />
            </span>
            <span
                className="flex items-center w-12 h-12 cursor-pointer bg-red-100 hover:bg-red-300 transition-all duration-300 rounded-full p-2"
                onClick={handleRemove}
            >
                <TrashIcon className="text-red-500 w-8 h-8" />
            </span>
        </>
    );
};

export default DropzonePreviewActions;
