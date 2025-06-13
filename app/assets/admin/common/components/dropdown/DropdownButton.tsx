import React, { FC } from 'react';

interface DropdownButtonProps {
    children: React.ReactNode;
    toggleDropdown?: () => void;
    onClickExtra?: () => void;
    className?: string;
}

const DropdownButton: FC<DropdownButtonProps> = ({ children, toggleDropdown, onClickExtra, className }) => {
    const handleClick = () => {
        toggleDropdown?.();
        if (onClickExtra) {
            onClickExtra();
        }
    };

    return (
        <div className={className} onClick={handleClick}>
            {children}
        </div>
    );
};

export default DropdownButton;
