import React from 'react';
import { DropdownProvider } from '@admin/shared/components/dropdown/DropdownContext';

interface DropdownProps {
  children: React.ReactNode;
}

const Dropdown: React.FC<DropdownProps> = ({ children }) => {
  return <DropdownProvider>{children}</DropdownProvider>;
};

export default Dropdown;
