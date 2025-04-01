import SideBar from './SideBar';
import TopBar from './TopBar';
import { Outlet } from 'react-router-dom';
import {NotificationProvider} from "@/admin/context/NotificationContext";

const AppLayout = () => {
    return (
        <>
            <SideBar />
            <div className="flex-1 transition-all duration-300 ease-in-out lg:ml-[290px] ">
                <TopBar />
                <NotificationProvider>
                    <div className="p-4 max-w-(--breakpoint-2xl) md:p-6 relative">
                        <Outlet />
                    </div>
                </NotificationProvider>
            </div>
        </>
    );
};

export default AppLayout;
