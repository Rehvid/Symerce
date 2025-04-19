import TrashIcon from '@/images/icons/trash.svg';
import AppButton from '@/admin/components/common/AppButton';
import { useModal } from '@/admin/hooks/useModal';
import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';

const TableRowDeleteAction = ({ onClick }) => {
    const { openModal, closeModal } = useModal();

    const handleClick = () => {
        const title = (
            <div className="flex flex-col items-center gap-3 px-6">
                <TrashIcon className="scale-[125%] text-gray-700" />
                <span>Czy na pewno chcesz usunąć ten element?</span>
            </div>
        );

        const confirmClick = () => {
            onClick();
            closeModal();
        };

        openModal(
            <>
                <ModalHeader title={title} />
                <ModalBody>
                    <div className="flex justify-between">
                        <AppButton
                            variant="primary"
                            additionalClasses="px-4 py-2.5 font-bold"
                            onClick={() => confirmClick()}
                        >
                            Tak
                        </AppButton>
                        <AppButton variant="secondary" additionalClasses="px-4 py-2.5 font-bold" onClick={closeModal}>
                            Nie
                        </AppButton>
                    </div>
                </ModalBody>
            </>,
        );
    };

    return (
        <AppButton onClick={handleClick} additionalClasses="text-gray-500">
            <TrashIcon />
        </AppButton>
    );
};

export default TableRowDeleteAction;
