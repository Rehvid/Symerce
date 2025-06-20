import { Suspense, lazy, FC } from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import adminRoutes from '@/admin/routes/AdminRoutes';
import publicRoutes from '@/admin/routes/PublicRoutes';
import SuspenseFallback from '@/admin/pages/SuspenseFallback';

const Forbidden = lazy(() => import('@/admin/pages/Forbidden'));
const NotFound = lazy(() => import('@/admin/pages/NotFound'));
const AdminLayout = lazy(() => import('@/admin/layouts/AdminLayout'));

const AppRouter: FC = () => {
    return (
        <BrowserRouter>
            <Suspense fallback={<SuspenseFallback />}>
                <Routes>
                    <Route path="/admin/public/">{publicRoutes}</Route>

                    <Route path="/admin/" element={<AdminLayout />}>
                        {adminRoutes}
                    </Route>

                    <Route path="/admin/forbidden" element={<Forbidden />} />
                    <Route path="*" element={<NotFound />} />
                </Routes>
            </Suspense>
        </BrowserRouter>
    );
};

export default AppRouter;
