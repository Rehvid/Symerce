import React, { FC } from 'react';
import { useDrawer } from '@admin/common/components/drawer/DrawerContext';

interface DrawerTriggerProps {
    children: React.ReactNode;
    classNames?: string;
}

const DrawerTrigger: FC<DrawerTriggerProps> = ({children, classNames}) => {
    const { toggle  } = useDrawer();

    return (
        <div className={classNames} onClick={toggle} >
            { children }
        </div>
    );
}

export default DrawerTrigger;
