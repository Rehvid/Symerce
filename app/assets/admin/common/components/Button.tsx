import React, { ButtonHTMLAttributes } from 'react';

export enum ButtonVariant {
    Primary = 'primary',
    Secondary = 'secondary',
    Link = 'link',
    SideBar = 'sideBar',
    Accept = 'accept',
    Decline = 'decline',
}

interface AppButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {
    variant: ButtonVariant;
    id?: string;
    additionalClasses?: string;
}

const variants = {
    [ButtonVariant.Primary]: 'bg-primary text-white hover:bg-primary-hover',
    [ButtonVariant.Secondary]: 'bg-secondary text-white hover:bg-secondary-hover',
    [ButtonVariant.Link]: 'bg-white text-gray-700 hover:bg-primary-hover hover:text-white',
    [ButtonVariant.SideBar]: 'text-gray-700 hover:bg-primary-hover hover:text-white',
    [ButtonVariant.Accept]: 'bg-success text-black hover:bg-success-hover',
    [ButtonVariant.Decline]: 'bg-error text-black hover:bg-error-hover',
};

const Button: React.FC<AppButtonProps> = ({
    children,
    id,
    variant,
    additionalClasses = '',
    type = 'button',
    ...props
}) => {
    return (
        <button
            id={id}
            type={type}
            className={`transition-all rounded-lg cursor-pointer px-4 py-2 text-lg ${variants[variant]} ${additionalClasses}`}
            {...props}
        >
            {children}
        </button>
    );
};

export default Button;
