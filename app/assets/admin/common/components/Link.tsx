import React from 'react';
import { NavLink, NavLinkProps } from 'react-router-dom';

export enum AppLinkVariant {
    Sidebar = 'sidebar',
    Default = 'default',
    Button = 'button',
}

interface AppLinkProps extends Omit<NavLinkProps, 'to' | 'children'> {
    to: string;
    state?: Record<string, unknown>;
    variant?: AppLinkVariant;
    additionalClasses?: string;
    children: React.ReactNode;
}

const Link: React.FC<AppLinkProps> = ({
                                             to,
                                             state = {},
                                             children,
                                             variant = AppLinkVariant.Default,
                                             additionalClasses = '',
                                             ...props
                                         }) => {
    const variants: Record<AppLinkVariant, string> = {
        [AppLinkVariant.Sidebar]: 'text-gray-700 rounded-lg hover:bg-primary hover:text-white',
        [AppLinkVariant.Default]: 'text-sm text-gray-500 hover:text-primary',
        [AppLinkVariant.Button]: 'text-sm rounded-lg font-medium text-gray-700 hover:bg-primary-hover hover:text-white',
    };

    const activeVariants: Record<AppLinkVariant, string> = {
        [AppLinkVariant.Sidebar]: 'bg-primary text-white font-medium hover:bg-primary',
        [AppLinkVariant.Default]: '',
        [AppLinkVariant.Button]: '',
    };

    return (
        <NavLink
            {...props}
            end
            to={to}
            state={state}
            className={({ isActive }) =>
                `transition-all ${variants[variant]} ${isActive ? activeVariants[variant] : ''} ${additionalClasses}`
            }
        >
            {children}
        </NavLink>
    );
};

export default Link;
