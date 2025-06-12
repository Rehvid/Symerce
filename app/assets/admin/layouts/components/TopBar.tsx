import React, { ReactNode, useEffect } from 'react';
import TopBarDropdown from '@/admin/layouts/components/partials/TopBarDropdown';
import MenuIcon from '@/images/icons/menu.svg';
import { useDrawer } from '@admin/common/components/drawer/DrawerContext';
import DrawerHeader from '@admin/common/components/drawer/DrawerHeader';
import { PositionType } from '@admin/common/enums/positionType';

interface TopBarProps {
    sideBarContent: ReactNode;
    isMobile: boolean;
}

const TopBar: React.FC<TopBarProps> = ({ sideBarContent, isMobile }) => {
    const { open, close } = useDrawer();

    const drawerContent = () => (
        <>
            <DrawerHeader>
                <div className="flex flex-col items-center gap-3 px-6">Nawigacja</div>
            </DrawerHeader>
            <div className="min-w-[275px]">{sideBarContent}</div>
        </>
    );

    useEffect(() => {
        if (!isMobile) {
            close();
        }
    }, [isMobile, close]);

    const openSideBarModal = () => {
        open('topbar-menu', drawerContent(), PositionType.LEFT);
    };

    return (
        <header className="sticky top-0 flex w-full items-center bg-white border-gray-200 z-300 border-b">
            <div className="px-4 lg:hidden">
                <MenuIcon onClick={openSideBarModal} />
            </div>

            <div className="flex justify-end grow flex-row max-w-(--breakpoint-2xl) px-5 py-4">
                <TopBarDropdown />
            </div>
        </header>
    );
};

export default TopBar;
