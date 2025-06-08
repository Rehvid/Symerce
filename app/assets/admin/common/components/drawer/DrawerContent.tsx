import React, { FC  } from 'react';
import { useDrawer } from '@admin/common/components/drawer/DrawerContext';
import { PositionType } from '@admin/common/enums/positionType';
import clsx from 'clsx';

interface DrawerContentProps {
    children?: React.ReactNode;
    position: PositionType;
    drawerId: string;
}

const DrawerContent: FC<DrawerContentProps> = ({ children, position, drawerId }) => {
    const { isOpen, ref } = useDrawer();

    const isDrawerOpen = isOpen(drawerId);

    const baseClasses = 'fixed z-[400] overflow-y-auto transition-transform bg-white';

    const positionClasses: Record<PositionType, string> = {
        [PositionType.LEFT]: 'top-0 left-0 h-screen max-w-96',
        [PositionType.RIGHT]: 'top-0 right-0 h-screen max-w-96',
        [PositionType.BOTTOM]: 'bottom-0 left-0 right-0 w-full',
        [PositionType.TOP]: 'top-0 left-0 right-0 w-full',
        [PositionType.CENTER]: 'top-1/2 left-1/2 -translate-x-1/2 transform max-w-md rounded-xl shadow-xl',
    };

    const transformClass = (() => {
        switch (position) {
            case PositionType.LEFT:
                return isDrawerOpen ? 'translate-x-0' : '-translate-x-full';
            case PositionType.RIGHT:
                return isDrawerOpen ? 'translate-x-0' : 'translate-x-full';
            case PositionType.BOTTOM:
                return isDrawerOpen ? 'translate-y-0' : 'translate-y-full';
            case PositionType.TOP:
                return isDrawerOpen ? 'translate-y-0' : '-translate-y-full';
            case PositionType.CENTER:
                return clsx(
                    'transform transition-all duration-300 ease-in-out',
                    isDrawerOpen
                        ? 'translate-y-[-50%] opacity-100 pointer-events-auto scale-100'
                        : 'translate-y-[-200%] opacity-0 pointer-events-none scale-95'
                );
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
