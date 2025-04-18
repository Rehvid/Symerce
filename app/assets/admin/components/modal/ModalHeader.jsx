import CloseIcon from '@/images/icons/close.svg';
import { useModal } from '@/admin/hooks/useModal';

const ModalHeader = ({ title }) => {
    const { closeModal } = useModal();

    return (
        <div className="border-b border-gray-200">
            <div className="flex justify-between gap-4 p-4">
                <h1 className="text-gray-500 text-xl font-semibold">{title}</h1>
                <CloseIcon className="text-gray-500 cursor-pointer" onClick={closeModal} />
            </div>
        </div>
    );
};

export default ModalHeader;
