import React, { FC } from 'react';
import { PositionType } from '@admin/common/enums/positionType';
import clsx from 'clsx';
import { motion } from 'framer-motion';

interface DrawerContentProps {
    children?: React.ReactNode;
    position: PositionType;
}

const DrawerContent: FC<DrawerContentProps> = ({ children, position }) => {
    const drawerVariants = {
        [PositionType.LEFT]: {
            initial: { x: '-100%' },
            animate: { x: 0 },
            exit: { x: '-100%' },
        },
        [PositionType.RIGHT]: {
            initial: { x: '100%' },
            animate: { x: 0 },
            exit: { x: '100%' },
        },
        [PositionType.TOP]: {
            initial: { y: '-100%' },
            animate: { y: 0 },
            exit: { y: '-100%' },
        },
        [PositionType.BOTTOM]: {
            initial: { y: '100%' },
            animate: { y: 0 },
            exit: { y: '100%' },
        },
        [PositionType.CENTER]: {
            initial: { y: '-200%', opacity: 0, scale: 0.95 },
            animate: { y: '-50%', opacity: 1, scale: 1 },
            exit: { y: '-200%', opacity: 0, scale: 0.95 },
        },
    };

    const positionClasses: Record<PositionType, string> = {
        [PositionType.LEFT]: 'top-0 left-0 h-screen max-w-96',
        [PositionType.RIGHT]: 'top-0 right-0 h-screen max-w-96',
        [PositionType.BOTTOM]: 'bottom-0 left-0 right-0 w-full',
        [PositionType.TOP]: 'top-0 left-0 right-0 w-full',
        [PositionType.CENTER]: 'top-1/2 left-1/2 -translate-x-1/2 transform max-w-4xl rounded-xl shadow-2xl',
    };

    return (
        <motion.div
            id="drawer"
            className={clsx('fixed z-[400] overflow-y-auto bg-white', positionClasses[position])}
            tabIndex={-1}
            initial={drawerVariants[position].initial}
            animate={drawerVariants[position].animate}
            exit={drawerVariants[position].exit}
            transition={{ type: 'spring', stiffness: 300, damping: 35, mass: 1 }}
        >
            {children}
        </motion.div>
    );
};

export default DrawerContent;
