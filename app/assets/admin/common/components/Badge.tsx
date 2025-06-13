import React, { ReactNode } from 'react';

export enum BadgeVariant {
    Info = 'info',
    Success = 'success',
    Error = 'error',
    Warning = 'warning',
}

interface BadgeProps {
    variant?: BadgeVariant;
    children: ReactNode;
}

const Badge: React.FC<BadgeProps> = ({ variant = BadgeVariant.Info, children }) => {
    const variants: Record<BadgeVariant, string> = {
        [BadgeVariant.Info]: 'bg-info text-black',
        [BadgeVariant.Success]: 'bg-success text-black',
        [BadgeVariant.Error]: 'bg-error text-black',
        [BadgeVariant.Warning]: 'bg-warning text-black',
    };

    return (
        <span className={`inline-flex items-center px-2 py-1 text-xs font-medium rounded-lg ${variants[variant]}`}>
            {children}
        </span>
    );
};

export default Badge;
