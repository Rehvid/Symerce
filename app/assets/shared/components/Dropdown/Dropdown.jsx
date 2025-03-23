import { Children, cloneElement, useState } from 'react';
import DropdownButton from './DropdownButton';

function Dropdown({ children }) {
    const [open, setOpen] = useState(false);
    const toggleOpen = () => {
        setOpen(prevState => !prevState);
    };

    return (
        <div>
            {Children.map(children, child => {
                if (child.type === DropdownButton) {
                    return cloneElement(child, { toggleDropdown: toggleOpen, ...child.props });
                }
                return cloneElement(child, { isOpen: open });
            })}
        </div>
    );
}

export default Dropdown;
