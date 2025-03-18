import { useState } from 'react';

function Submenu({ buttonLabel, children }) {
    const [open, setOpen] = useState(false);
    const handleToggle = () => {
        setOpen(prev => !prev);
    };

    return (
        <div>
            <button
                className={`transition-all block py-2 px-4 text-gray-900 rounded-lg hover:bg-indigo-500 hover:text-white w-full flex justify-start cursor-pointer ${open ? 'bg-indigo-500 hover:bg-indigo-500 text-white ' : 'text-gray-900'}`}
                onClick={handleToggle}
            >
                {buttonLabel}
            </button>
            <div
                className={`overflow-hidden transition-all duration-300 ease-in-out ${
                    open ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'
                }`}
            >
                <ul className="mt-2 space-y-1 ml-9">{children}</ul>
            </div>
        </div>
    );
}

export default Submenu;
