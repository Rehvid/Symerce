import { createContext, useState } from 'react';
import ModalBackground from '@/admin/components/modal/ModalBackground';

export const ModalContext = createContext({});

export const ModalProvider = ({ children }) => {
    const [isOpen, setIsOpen] = useState(false);
    const [modalContent, setModalContent] = useState(null);

    const openModal = (content) => {
        setModalContent(content);
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
                    className={`backdrop-blur-lg overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-310 w-full h-[calc(100%-1rem)] max-h-full`}
                >
                    <ModalBackground>{modalContent}</ModalBackground>
                </div>
            )}
        </ModalContext.Provider>
    );
};
