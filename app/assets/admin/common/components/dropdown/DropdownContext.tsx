import React, { createContext, useContext, useState, useRef } from 'react';
import useClickOutside from '@admin/common/hooks/useClickOutside';

interface DropdownContextProps {
  isOpen: boolean;
  toggle: () => void;
  close: () => void;
  ref: React.RefObject<HTMLDivElement>;
}

const DropdownContext = createContext<DropdownContextProps | undefined>(undefined);

export const DropdownProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [isOpen, setIsOpen] = useState(false);
  const ref = useRef<HTMLDivElement>(null);

  const toggle = () => setIsOpen((prev) => !prev);
  const close = () => setIsOpen(false);

  useClickOutside(ref, close);

  return (
    <DropdownContext.Provider value={{ isOpen, toggle, close, ref }}>
      {children}
    </DropdownContext.Provider>
  );
};

export const useDropdown = () => {
  const context = useContext(DropdownContext);
  if (!context) {
    throw new Error('useDropdown must be used within a DropdownProvider');
  }
  return context;
};
