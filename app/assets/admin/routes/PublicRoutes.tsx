import { Route } from 'react-router-dom';
import { lazy, LazyExoticComponent } from 'react';
import { ComponentType } from 'react';

interface RouteConfig {
    path: string;
    component: LazyExoticComponent<ComponentType<any>>;
}

const routesConfig: RouteConfig[] = [
    { path: 'login', component: lazy(() => import('@/admin/modules/authentication/pages/Login')) },
    { path: 'remind-password', component: lazy(() => import('@/admin/modules/authentication/pages/RemindPassword')) },
    { path: 'reset-password', component: lazy(() => import('@/admin/modules/authentication/pages/ResetPassword')) },
];

const publicRoutes = routesConfig.map(({ path, component: Component }) => (
    <Route key={path} path={path} element={<Component />} />
));

export default publicRoutes;
