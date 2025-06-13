import React from 'react';
import { useDrawer } from '@admin/common/components/drawer/DrawerContext';
import { createPortal } from 'react-dom';
import DrawerContent from '@admin/common/components/drawer/DrawerContent';
import { AnimatePresence, motion } from 'framer-motion';

interface DrawerRendererProps {
    portalContainer: HTMLElement | null;
    clearContent: () => void;
}

const DrawerRenderer: React.FC<DrawerRendererProps> = ({ portalContainer, clearContent }) => {
    const { activeDrawerId, drawerContent, drawerPosition, close } = useDrawer();

    if (!portalContainer) return null;

    return createPortal(
        <AnimatePresence
            onExitComplete={() => {
                clearContent();
            }}
        >
            {activeDrawerId && drawerContent && (
                <>
                    <motion.div
                        key="backdrop"
                        className="fixed inset-0 bg-black/80 z-[399]"
                        onClick={close}
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        transition={{ duration: 0.3 }}
                    />
                    <DrawerContent key={activeDrawerId} position={drawerPosition}>
                        {drawerContent}
                    </DrawerContent>
                </>
            )}
        </AnimatePresence>,
        portalContainer,
    );
};
export default DrawerRenderer;
