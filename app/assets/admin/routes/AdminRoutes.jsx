import { Route } from 'react-router-dom';
import { lazy } from 'react';
import ProtectedRoute from '@/admin/routes/ProtectedRoute';

const routesConfig = [
    {
        path: 'profile',
        component: lazy(() => import('@/admin/pages/Profile')),
        roles: ['user'],
    },
    {
        path: 'dashboard',
        component: lazy(() => import('@/admin/pages/Dashboard')),
        roles: ['user'],
    },
    {
        path: 'products',
        component: lazy(() => import('@/admin/pages/product/ProductList')),
        roles: ['user', 'seo'],
    },
    {
        path: 'categories',
        component: lazy(() => import('@/admin/pages/category/CategoryList')),
        roles: ['user'],
    },
    {
        path: 'categories/create',
        component: lazy(() => import('@/admin/pages/category/CategoryEditor')),
        roles: ['user', 'admin'],
    },
    {
        path: 'categories/:id/edit',
        component: lazy(() => import('@/admin/pages/category/CategoryEditor')),
        roles: ['user', 'admin'],
    },
    {
        path: 'users',
        component: lazy(() => import('@/admin/pages/user/UserList')),
        roles: ['admin']
    }
];

const withProtection = (requiredRoles, Component) => (
    <ProtectedRoute requiredRoles={requiredRoles}>
        <Component />
    </ProtectedRoute>
);

const adminRoutes = routesConfig.map(({ path, component, roles }) => (
    <Route key={path} path={path} element={withProtection(roles, component)} />
));

export default adminRoutes;
