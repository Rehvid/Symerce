import EyeIcon from '@/images/icons/eye.svg';
import TrashIcon from '@/images/icons/trash.svg';
import React from 'react';
import { useModal } from '@/admin/hooks/useModal';

const AppDropzoneThumbnail = ({ file, renderModal, removeFile }) => {
    const { openModal } = useModal();

    return (
        <>
            <img className="rounded-lg max-h-[140px] mx-auto" src={file.preview} alt={file.name} />
            <div className="absolute rounded-lg transition-all w-full h-full inset-0 flex items-center justify-center gap-3 hover:backdrop-blur-xl ">
                {renderModal && (
                    <span className="block cursor-pointer" onClick={() => openModal(renderModal(file))}>
                        <EyeIcon className="text-white scale-125%" />
                    </span>
                )}
                <span
                    className="block cursor-pointer"
                    onClick={() => {
                        removeFile(file);
                    }}
                >
                    <TrashIcon className="text-white scale-125%" />
                </span>
            </div>
        </>
    );
};

export default AppDropzoneThumbnail;
