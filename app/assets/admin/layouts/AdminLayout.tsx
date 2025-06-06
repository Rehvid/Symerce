import { Navigate, Outlet } from 'react-router-dom';
import SideBar from '@/admin/layouts/components/SideBar';
import TopBar from '@/admin/layouts/components/TopBar';
import React, { useEffect, useState } from 'react';


import { useAuth } from '@admin/common/context/AuthroizationContext';
import { useUser } from '@admin/common/context/UserContext';
import { useIsMobile } from '@admin/common/hooks/useIsMobile';
import { NotificationProvider } from '@admin/common/context/NotificationContext';
import { ModalProvider } from '@admin/common/context/ModalContext';

const AdminLayout: React.FC  = () => {
    const isMobile = useIsMobile();
    const { isLoadingAuthorization, verifyAuth } = useAuth();
    const { isAuthenticated } = useUser();
    const [sideBarContent, setSideBarContent] = useState(null);

    useEffect(() => {
        verifyAuth();
    }, []);

    if (isLoadingAuthorization) {
        return null;
    }

    if (!isAuthenticated) {
        return <Navigate to="/admin/public/login" />;
    }

    return (
        <ModalProvider>
            <div className="flex-1 transition-all duration-300 ease-in-out lg:ml-[290px] ">
                <SideBar isMobile={isMobile} setSideBarContent={setSideBarContent} />
                <TopBar isMobile={isMobile} sideBarContent={sideBarContent} />
                <NotificationProvider>
                    <div className="max-w-(--breakpoint-2xl) p-5 relative">
                        <Outlet />
                    </div>
                </NotificationProvider>
            </div>
        </ModalProvider>
    );
};

export default AdminLayout;
