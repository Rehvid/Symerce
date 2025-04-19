import { useState } from 'react';
import ChevronIcon from '@/images/icons/chevron.svg';

const Submenu = ({ buttonLabel, children }) => {
    const [open, setOpen] = useState(false);
    const handleToggle = () => {
        setOpen((prev) => !prev);
    };

    return (
        <li>
            <button
                className={`transition-all block py-2 px-5 text-gray-900 rounded-lg hover:bg-indigo-500 hover:text-white w-full flex justify-between cursor-pointer ${open ? 'bg-indigo-500 hover:bg-indigo-500 text-white ' : 'text-gray-900'}`}
                onClick={handleToggle}
            >
                {buttonLabel}
                <ChevronIcon className={`${open ? 'rotate-180' : 'rotate-0'} transition-transform duration-300`} />
            </button>
            <div
                className={`overflow-hidden transition-all duration-300 ease-in-out ${
                    open ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'
                }`}
            >
                <ul className="mt-4 space-y-1 ml-9 flex flex-col gap-2">{children}</ul>
            </div>
        </li>
    );
};

export default Submenu;
