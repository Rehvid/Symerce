import React, { createContext, FC, ReactNode, useContext, useState } from 'react';
import { PositionType } from '@admin/common/enums/positionType';
import DrawerRenderer from '@admin/common/components/drawer/DrawerRenderer';

interface DrawerContextProps {
    activeDrawerId: string | null;
    drawerContent: ReactNode | null;
    drawerPosition: PositionType;
    open: (id: string, content: ReactNode, position?: PositionType) => void;
    close: () => void;
    isOpen: (id: string) => boolean;
}

const DrawerContext = createContext<DrawerContextProps | undefined>(undefined);

export const DrawerProvider: FC<{ children: ReactNode }> = ({ children }) => {
    const [activeDrawerId, setActiveDrawerId] = useState<string | null>(null);
    const [drawerContent, setDrawerContent] = useState<ReactNode | null>(null);
    const [drawerPosition, setDrawerPosition] = useState<PositionType>(PositionType.RIGHT);
    const open = (id: string, content: ReactNode, position: PositionType = PositionType.RIGHT) => {
        setDrawerContent(content);
        setDrawerPosition(position);
        setActiveDrawerId(id);
    };

    const close = () => {
        setActiveDrawerId(null);
    };

    const isOpen = (id: string) => activeDrawerId === id;

    const clearContent = () => {
        setDrawerContent(null);
    };
    return (
        <DrawerContext.Provider value={{ activeDrawerId, drawerContent, drawerPosition, open, close, isOpen }}>
            {children}
            <DrawerRenderer portalContainer={document.getElementById('drawer-root')} clearContent={clearContent} />
        </DrawerContext.Provider>
    );
};

export const useDrawer = () => {
    const context = useContext(DrawerContext);
    if (!context) {
        throw new Error('useDrawer must be used within a DrawerProvider');
    }
    return context;
};
