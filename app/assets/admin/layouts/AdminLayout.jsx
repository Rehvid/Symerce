import { Navigate, Outlet } from 'react-router-dom';
import SideBar from '@/admin/layouts/components/SideBar';
import TopBar from '@/admin/layouts/components/TopBar';
import { NotificationProvider } from '@/admin/store/NotificationContext';
import { ModalProvider } from '@/admin/store/ModalContext';
import { useEffect } from 'react';
import { useUser } from '@/admin/hooks/useUser';
import { useAuth } from '@/admin/hooks/useAuth';

const AdminLayout = () => {
  const { isLoadingAuthorization, verifyAuth } = useAuth();
  const { isAuthenticated } = useUser();

  useEffect(() => {
    verifyAuth();
  }, []);

  if (isLoadingAuthorization || !isAuthenticated) {
    return null;
  }

  if (!isAuthenticated) {
    return <Navigate to="/admin/public/login" />;
  }

    return (
        <ModalProvider>
            <SideBar />
            <div className="flex-1 transition-all duration-300 ease-in-out lg:ml-[290px] ">
                <TopBar />
                <NotificationProvider>
                    <div className="max-w-(--breakpoint-2xl) p-6 relative">
                        <Outlet />
                    </div>
                </NotificationProvider>
            </div>
        </ModalProvider>
    );
};

export default AdminLayout;
