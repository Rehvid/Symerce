import React, { Children, cloneElement, FC, isValidElement, useEffect, useState } from 'react';
import DropdownButton from './DropdownButton';

interface DropdownProps {
    forceClose?: boolean;
    children?: React.ReactNode;
}

const Dropdown: FC<DropdownProps> = ({ forceClose, children }) => {
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
                if (!isValidElement(child)) return child;

                if (child.type === DropdownButton) {
                    return cloneElement(child, { toggleDropdown: toggleOpen, ...child.props });
                }
                return cloneElement(child as React.ReactElement<{ isOpen?: boolean }>, {
                    isOpen: open,
                });
            })}
        </div>
    );
};

export default Dropdown;
