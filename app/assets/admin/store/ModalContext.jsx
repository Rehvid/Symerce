import { createContext, useState } from 'react';
import ModalBackground from '@/admin/components/modal/ModalBackground';
import { POSITION_TYPES as POSITION_TYPE } from '@/admin/constants/positionConstants';

export const ModalContext = createContext({});

export const ModalProvider = ({ children }) => {
    const [isOpen, setIsOpen] = useState(false);
    const [modalContent, setModalContent] = useState(null);
    const [position, setPosition] = useState(POSITION_TYPE.CENTER);

    const openModal = (content, newPosition = POSITION_TYPE.CENTER) => {
        setModalContent(content);
        setPosition(newPosition);
        setIsOpen(true);
    };

    const closeModal = () => {
        setIsOpen(false);
        setModalContent(null);
    };

    return (
        <ModalContext.Provider value={{ isOpen, openModal, closeModal }}>
            {children}
            {isOpen && (
                <div
                    id="popup-modal"
                    tabIndex="-1"
                    className={`bg-black/85 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-350 w-full h-screen `}
                >
                    <ModalBackground position={position}>{modalContent}</ModalBackground>
                </div>
            )}
        </ModalContext.Provider>
    );
};
