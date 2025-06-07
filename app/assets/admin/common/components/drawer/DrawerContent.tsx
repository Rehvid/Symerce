import React, { FC  } from 'react';
import { useDrawer } from '@admin/common/components/drawer/DrawerContext';
import { PositionType } from '@admin/common/enums/positionType';
import clsx from 'clsx';

interface DrawerContentProps {
    children?: React.ReactNode;
    position: PositionType;
}

const DrawerContent: FC<DrawerContentProps> = ({ children, position }) => {
    const { isOpen, ref } = useDrawer();

    const baseClasses = 'fixed z-[400] overflow-y-auto transition-transform bg-white';

    const positionClasses: Record<PositionType, string> = {
        [PositionType.LEFT]: 'top-0 left-0 h-screen max-w-96',
        [PositionType.RIGHT]: 'top-0 right-0 h-screen max-w-96',
        [PositionType.BOTTOM]: 'bottom-0 left-0 right-0 w-full',
        [PositionType.TOP]: 'top-0 left-0 right-0 w-full',
    };

    const transformClass = (() => {
        switch (position) {
            case PositionType.LEFT:
                return isOpen ? 'translate-x-0' : '-translate-x-full';
            case PositionType.RIGHT:
                return isOpen ? 'translate-x-0' : 'translate-x-full';
            case PositionType.BOTTOM:
                return isOpen ? 'translate-y-0' : 'translate-y-full';
            case PositionType.TOP:
                return isOpen ? 'translate-y-0' : '-translate-y-full';
            default:
                return '';
        }
    })();

    return (
        <div
            ref={ref}
            id="drawer"
            className={clsx(baseClasses, positionClasses[position], transformClass)}
            tabIndex={-1}
        >
            {children}
        </div>
    );
};

export default DrawerContent;
