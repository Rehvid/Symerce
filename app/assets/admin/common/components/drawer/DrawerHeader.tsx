import React, { FC } from 'react';
import CloseIcon from '@/images/icons/close.svg';
import { useDrawer } from '@admin/common/components/drawer/DrawerContext';
import clsx from 'clsx';

interface DrawerHeaderProps  {
    children?: React.ReactNode;
}

const DrawerHeader: FC<DrawerHeaderProps> = ({children}) => {
    const { close } = useDrawer();
    const isChildren = !!children;

    return (
        <div className={clsx('flex gap-2 items-center mb-[0.5rem]  bg-gray-100 p-4', {
            'justify-between': isChildren,
            'justify-end': !isChildren,
        })}>
            {children && (children)}
            <CloseIcon
                className="cursor-pointer w-[24px] h-[24px] text-gray-400 hover:text-gray-500 transition-colors"
                onClick={close}
            />
        </div>
    )
}

export default DrawerHeader;
