import React, { ReactNode } from 'react';
import AppLink from '@/admin/components/common/AppLink';

interface NavigationItemProps {
    to: string;
    children: ReactNode;
}

const NavigationItem: React.FC<NavigationItemProps> = ({ children, to }) => {
    return (
        <li>
            <AppLink
                to={to}
                variant="sidebar"
                additionalClasses="flex items-center gap-2 py-2 px-5"
            >
                {children}
            </AppLink>
        </li>
    );
};

export default NavigationItem;
