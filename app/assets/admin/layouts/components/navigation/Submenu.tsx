import React, { ReactNode, useState } from 'react';
import ChevronIcon from '@/images/icons/chevron.svg';

interface SubmenuProps {
    buttonLabel: ReactNode;
    children: ReactNode;
}

const Submenu: React.FC<SubmenuProps> = ({ buttonLabel, children }) => {
    const [open, setOpen] = useState<boolean>(false);

    const handleToggle = (): void => {
        setOpen((prev) => !prev);
    };

    return (
        <li>
            <button
                className={`
          transition-all block py-2 px-5 rounded-lg hover:bg-secondary hover:text-white w-full flex justify-between cursor-pointer
          ${open ? 'bg-secondary text-white' : 'text-gray-900'}
        `}
                onClick={handleToggle}
            >
                {buttonLabel}
                <ChevronIcon
                    className={`
            ${open ? 'rotate-180' : 'rotate-0'} transition-transform duration-300 h-[24px] w-[24px]
          `}
                />
            </button>
            <div
                className={`
          overflow-hidden transition-all duration-300 ease-in-out
          ${open ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'}
        `}
            >
                <ul className="mt-4 space-y-1 ml-4 flex flex-col gap-2">{children}</ul>
            </div>
        </li>
    );
};

export default Submenu;
