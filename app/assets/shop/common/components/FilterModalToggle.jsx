import { useClickToggleBySelector } from '@/shop/hooks/useClickToggleBySelector';
import Modal from '@/shop/components/Modal';
import { POSITION_TYPES } from '@/admin/constants/positionConstants';
import ModalHeader from '@admin/common/components/modal/ModalHeader';
import ModalBody from '@admin/common/components/form/ModalBody';

const FilterModalToggle = ({ items = [] }) => {
  const handler = () => openModal();

  const { open, openModal, closeModal } = useClickToggleBySelector(true, '.react-filter-toggle', handler);

  if (!open) {
    return null;
  }

  return (
    <Modal isOpen={open} position={POSITION_TYPES.RIGHT}>
      <ModalHeader title="Filtry" extraCloseModal={() => closeModal()} />
      <ModalBody></ModalBody>
    </Modal>
  );
}

export default FilterModalToggle;
