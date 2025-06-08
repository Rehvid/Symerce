import React, { FC } from 'react';
import { useDrawer } from '@admin/common/components/drawer/DrawerContext';

interface DrawerTriggerProps {
    children: React.ReactNode;
    classNames?: string;
    drawerId: string;
}

const DrawerTrigger: FC<DrawerTriggerProps> = ({children, classNames, drawerId}) => {
    const { toggle } = useDrawer();

    return (
        <div className={classNames} onClick={() => toggle(drawerId)}>
            { children }
        </div>
    );
}

export default DrawerTrigger;
