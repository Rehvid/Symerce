import React from 'react';
import { useDropdown } from './DropdownContext';

interface DropdownContentProps {
  children: React.ReactNode;
  containerClasses?: string;
}

const DropdownContent: React.FC<DropdownContentProps> = ({ children, containerClasses = '' }) => {
  const { isOpen, ref } = useDropdown();

  if (!isOpen) return null;

  return (
    <div ref={ref}
      className={`transition-all ease-in-out duration-500 ${
        isOpen ? 'opacity-100 visible' : 'opacity-0 invisible'
      } relative z-50`}
    >
      <div
        className={`absolute bg-white shadow-lg rounded-lg border border-gray-200 p-3 w-full mt-2 max-h-[200px] overflow-auto ${
          isOpen ? 'scale-y-100  opacity-100 visible' : 'scale-y-0 opacity-0 overflow-hidden'
        } ${containerClasses}`}
      >
        {children}
      </div>
    </div>
  );
};

export default DropdownContent;
