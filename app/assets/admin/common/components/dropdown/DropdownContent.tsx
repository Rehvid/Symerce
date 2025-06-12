import React, { FC } from 'react';

interface DropdownContentProps {
    isOpen?: boolean;
    children?: React.ReactNode;
    containerClasses?: string;
}

const DropdownContent: FC<DropdownContentProps> = ({ isOpen, children, containerClasses = '' }) => (
    <div
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


export default DropdownContent;
