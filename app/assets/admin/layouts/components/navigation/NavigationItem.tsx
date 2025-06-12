import React, { ReactNode } from 'react';
import Link, { AppLinkVariant } from '@admin/common/components/Link';

interface NavigationItemProps {
    to: string;
    children: ReactNode;
}

const NavigationItem: React.FC<NavigationItemProps> = ({ children, to }) => {
    return (
        <li>
            <Link
                to={to}
                variant={AppLinkVariant.Sidebar}
                additionalClasses="flex items-center gap-2 py-2 px-5"
            >
                {children}
            </Link>
        </li>
    );
};

export default NavigationItem;
