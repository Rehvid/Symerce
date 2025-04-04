import { Outlet } from 'react-router-dom';
import SideBar from '@/admin/layouts/components/SideBar';
import TopBar from '@/admin/layouts/components/TopBar';
import { NotificationProvider } from '@/admin/store/NotificationContext';

const AdminLayout = () => {
    return (
        <>
            <SideBar />
            <div className="flex-1 transition-all duration-300 ease-in-out lg:ml-[290px] ">
                <TopBar />
                <NotificationProvider>
                    <div className="max-w-(--breakpoint-2xl) p-6 relative">
                        <Outlet />
                    </div>
                </NotificationProvider>
            </div>
        </>
    );
};

export default AdminLayout;
