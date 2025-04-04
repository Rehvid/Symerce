import { Children, cloneElement, useEffect, useState } from 'react';
import DropdownButton from './DropdownButton';

function Dropdown({ forceClose, children }) {
    const [open, setOpen] = useState(false);
    const toggleOpen = () => {
        setOpen((prevState) => !prevState);
    };

    useEffect(() => {
        if (forceClose) {
            setOpen(false);
        }
    }, [forceClose]);

    return (
        <div>
            {Children.map(children, (child) => {
                if (child.type === DropdownButton) {
                    return cloneElement(child, { toggleDropdown: toggleOpen, ...child.props });
                }
                return cloneElement(child, { isOpen: open });
            })}
        </div>
    );
}

export default Dropdown;
