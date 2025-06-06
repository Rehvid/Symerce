import TrashIcon from '@/images/icons/trash.svg';
import Button from '@admin/common/components/Button';
import { useModal } from '@admin/common/context/ModalContext';
import ModalHeader from '@admin/common/components/modal/ModalHeader';
import ModalBody from '@admin/common/components/form/ModalBody';

const TableRowDeleteAction = ({ onClick }) => {
    const { openModal, closeModal } = useModal();

    const handleClick = () => {
        const title = (
            <div className="flex flex-col items-center gap-3 px-6">
                <TrashIcon className="w-[24px] h-[24px] text-error" />
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
                    <div className="flex flex-col gap-5">
                        <Button
                            variant="decline"
                            additionalClasses="px-4 py-2.5 font-bold  w-full text-center"
                            onClick={() => confirmClick()}
                        >
                            Potwierdź usunięcie
                        </Button>
                        <Button
                            variant="secondary"
                            additionalClasses="px-4 py-2.5 font-bold w-full text-center "
                            onClick={closeModal}
                        >
                            Anuluj operację
                        </Button>
                    </div>
                </ModalBody>
            </>,
        );
    };

    return (
        <Button onClick={handleClick} additionalClasses="text-gray-500">
            <TrashIcon className="w-[24px] h-[24px]" />
        </Button>
    );
};

export default TableRowDeleteAction;
