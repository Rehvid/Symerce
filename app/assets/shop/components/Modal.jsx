import ModalBackground from '@/admin/components/modal/ModalBackground';

const Modal = ({ isOpen, position, children }) => {
    if (!isOpen) {
        return null;
    }

    return (
        isOpen && (
            <div
                id="popup-modal"
                tabIndex="-1"
                className={`bg-black/85 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-350 w-full h-screen `}
            >
                <ModalBackground position={position}>{children}</ModalBackground>
            </div>
        )
    );
};

export default Modal;
