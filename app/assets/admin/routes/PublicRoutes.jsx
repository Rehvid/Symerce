import { Route } from 'react-router-dom';
import { lazy } from 'react';

const routesConfig = [
    { path: 'register', component: lazy(() => import('@/admin/pages/auth/Register')) },
    { path: 'login', component: lazy(() => import('@/admin/pages/auth/Login')) },
    { path: 'forgot-password', component: lazy(() => import('@/admin/pages/auth/ForgetPassword')) },
    { path: 'reset-password', component: lazy(() => import('@/admin/pages/auth/ResetPassword')) },
];

const publicRoutes = routesConfig.map(({ path, component: Component }) => (
    <Route key={path} path={path} element={<Component />} />
));

export default publicRoutes;
