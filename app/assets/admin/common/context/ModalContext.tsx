import React, { createContext, ReactNode, useContext, useState } from 'react';
import ModalBackground from '@admin/common/components/modal/ModalBackground';
import { ModalPositionType } from '@admin/common/enums/modalPositionType';


interface ModalContextType {
  isOpen: boolean;
  openModal: (content: ReactNode, position?: ModalPositionType) => void;
  closeModal: () => void;
}

export const ModalContext = createContext<ModalContextType | undefined>(undefined);

interface ModalProviderProps {
  children: ReactNode;
}

export const ModalProvider: React.FC<ModalProviderProps> = ({ children }) => {
  const [isOpen, setIsOpen] = useState(false);
  const [modalContent, setModalContent] = useState<ReactNode>(null);
  const [position, setPosition] = useState<ModalPositionType>(ModalPositionType.CENTER);

  const openModal = (content: ReactNode, newPosition: ModalPositionType = ModalPositionType.CENTER) => {
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
          tabIndex={-1}
          className="bg-black/85 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-350 w-full h-screen"
        >
          <ModalBackground position={position}>
            {modalContent}
          </ModalBackground>
        </div>
      )}
    </ModalContext.Provider>
  );
};

export const useModal = (): ModalContextType => {
  const context = useContext(ModalContext);
  if (!context) {
    throw new Error('useModal must be used within a ModalProvider');
  }
  return context;
};
