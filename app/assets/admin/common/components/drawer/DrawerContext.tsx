import React, { createContext, FC, useContext, useRef, useState } from 'react';
import useClickOutside from '@admin/common/hooks/useClickOutside';

interface DrawerContextProps {
    isOpen: boolean;
    toggle: () => void;
    close: () => void;
    ref: React.RefObject<HTMLDivElement>;
}

const DrawerContext = createContext<DrawerContextProps | undefined>(undefined);

export const DrawerProvider: FC<{ children: React.ReactNode }> = ({ children }) => {
    const [isOpen, setIsOpen] = useState(false);
    const ref = useRef<HTMLDivElement>(null);

    const toggle = () => setIsOpen(prevState => !prevState);
    const close = () => setIsOpen(false);

    useClickOutside(ref, close);

    return (
        <DrawerContext.Provider value={{ isOpen, toggle, close, ref }}>
            {isOpen && (
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
