import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';
import Modal from '@/shop/components/Modal';
import { POSITION_TYPES } from '@/admin/constants/positionConstants';
import { useClickToggleBySelector } from '@/shop/hooks/useClickToggleBySelector';

export const UserModalToggle = () => {
    const handler = () => openModal();

    const { open, openModal, closeModal } = useClickToggleBySelector(true, '.react-user-modal-toggle', handler);

    if (!open) {
        return null;
    }

    return (
        <Modal isOpen={open} position={POSITION_TYPES.RIGHT}>
            <ModalHeader title="Użytkownik" extraCloseModal={() => closeModal()} />
            <ModalBody>
                <div className="flex flex-col gap-[2rem] justify-between lg:w-[500px]">//TODO: Add to login user</div>
            </ModalBody>
        </Modal>
    );
};
