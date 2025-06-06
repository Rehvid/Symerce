import { useClickToggleBySelector } from '@/shop/hooks/useClickToggleBySelector';
import Modal from '@/shop/components/Modal';
import { POSITION_TYPES } from '@/admin/constants/positionConstants';
import ModalHeader from '@admin/common/components/modal/ModalHeader';
import ModalBody from '@admin/common/components/form/ModalBody';
import { useIsMobile } from '@/admin/hooks/useIsMobile';
import { useEffect } from 'react';

const MenuModalToggle = ({ items = [] }) => {
    const isMobile = useIsMobile();

    const handler = () => openModal();

    const { open, openModal, closeModal } = useClickToggleBySelector(true, '.react-menu-modal-toggle', handler);

    useEffect(() => {
        if (!isMobile) {
            closeModal();
        }
    }, [isMobile]);

    if (!open) {
        return null;
    }

    return (
        <Modal isOpen={open} position={POSITION_TYPES.RIGHT}>
            <ModalHeader title="Menu" extraCloseModal={() => closeModal()} />
            <ModalBody>
                <ul className="flex flex-col gap-2 justify-between lg:w-[500px]">
                    {items.map((item, key) => (
                        <li key={key}>
                            <a className="flex items-center h-[46px] w-full" href={item.url}>
                                {item.name}
                            </a>
                        </li>
                    ))}
                </ul>
            </ModalBody>
        </Modal>
    );
};

export default MenuModalToggle;
