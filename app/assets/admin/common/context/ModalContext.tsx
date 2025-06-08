import React, { createContext, ReactNode, useContext, useState } from 'react';
import ModalBackground from '@admin/common/components/modal/ModalBackground';
import { PositionType } from '@admin/common/enums/positionType';


interface ModalContextType {
  isOpen: boolean;
  openModal: (content: ReactNode, position?: PositionType) => void;
  closeModal: () => void;
}

export const ModalContext = createContext<ModalContextType | undefined>(undefined);

interface ModalProviderProps {
  children: ReactNode;
}

export const ModalProvider: React.FC<ModalProviderProps> = ({ children }) => {
  const [isOpen, setIsOpen] = useState(false);
  const [modalContent, setModalContent] = useState<ReactNode>(null);
  const [position, setPosition] = useState<PositionType>(PositionType.CENTER);

  const openModal = (content: ReactNode, newPosition: PositionType = PositionType.CENTER) => {
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
