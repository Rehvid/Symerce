import React from 'react';
import { useDropdown } from './DropdownContext';

interface DropdownButtonProps {
  children: React.ReactNode;
  className?: string;
}

const DropdownButton: React.FC<DropdownButtonProps> = ({ children, className = '' }) => {
  const { toggle } = useDropdown();
  return (
    <button
      onClick={toggle}
      className={className}
      type="button"
    >
      {children}
    </button>
  );
};
export default DropdownButton;
