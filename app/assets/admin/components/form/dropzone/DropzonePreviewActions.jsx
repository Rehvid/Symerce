import EyeIcon from '@/images/icons/eye.svg';
import TrashIcon from '@/images/icons/trash.svg';
import { useModal } from '@/admin/hooks/useModal';

const DropzonePreviewActions = ({ renderModal, removeFile, file }) => {
    const { openModal } = useModal();

    return (
        <>
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
        </>
    );
};

export default DropzonePreviewActions;
