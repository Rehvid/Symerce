import React, { createContext, FC, useContext, useRef, useState } from 'react';

interface DrawerContextProps {
    activeDrawerId: string | null;
    toggle: (drawerId: string) => void;
    close: () => void;
    isOpen: (drawerId: string) => boolean;
    ref: React.RefObject<HTMLDivElement>;
}


const DrawerContext = createContext<DrawerContextProps | undefined>(undefined);

export const DrawerProvider: FC<{ children: React.ReactNode }> = ({ children }) => {
    const [activeDrawerId, setActiveDrawerId] = useState<string | null>(null);
    const ref = useRef<HTMLDivElement>(null);

    const toggle = (drawerId: string) => {
        setActiveDrawerId(current => current === drawerId ? null : drawerId);
    };

    const close = () => setActiveDrawerId(null);

    const isOpen = (drawerId: string) => activeDrawerId === drawerId;


    return (
        <DrawerContext.Provider value={{ activeDrawerId, toggle, close, isOpen, ref }}>
            {activeDrawerId && (
                <div className="fixed inset-0 bg-black/85 bg-opacity-50 z-400" />
            )}
            {children}
        </DrawerContext.Provider>
    );
}

export const useDrawer = () => {
    const context = useContext(DrawerContext);
    if (!context) {
        throw new Error('useDrawer must be used within a DrawerProvider');
    }
    return context;
};
