import React, { ReactNode } from 'react';

interface MainLayoutProps {
    children: ReactNode;
}

const MainLayout: React.FC<MainLayoutProps> = ({ children }) => {
    return <section className="bg-background-base min-h-screen">{children}</section>;
};

export default MainLayout;
