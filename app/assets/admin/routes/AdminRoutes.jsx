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
        roles: ['user'],
    },
    {
        path: 'products/create',
        component: lazy(() => import('@/admin/pages/product/ProductForm')),
        roles: ['user'],
    },
    {
        path: 'products/:id/edit',
        component: lazy(() => import('@/admin/pages/product/ProductForm')),
        roles: ['user'],
    },
    {
        path: 'products/attributes',
        component: lazy(() => import('@/admin/pages/product/attribute/AttributeList')),
        roles: ['user'],
    },
    {
        path: 'products/attributes/create',
        component: lazy(() => import('@/admin/pages/product/attribute/AttributeForm')),
        roles: ['user'],
    },
    {
        path: 'products/attributes/:id/edit',
        component: lazy(() => import('@/admin/pages/product/attribute/AttributeForm')),
        roles: ['user'],
    },
    {
        path: 'products/attributes/:attributeId/values',
        component: lazy(() => import('@/admin/pages/product/attribute/attribute-value/AttributeValueList')),
        roles: ['user'],
    },
    {
        path: 'products/attributes/:attributeId/values/create',
        component: lazy(() => import('@/admin/pages/product/attribute/attribute-value/AttributeValueForm')),
        roles: ['user'],
    },
    {
        path: 'products/attributes/:attributeId/values/:id/edit',
        component: lazy(() => import('@/admin/pages/product/attribute/attribute-value/AttributeValueForm')),
        roles: ['user'],
    },
    {
        path: 'products/vendors',
        component: lazy(() => import('@/admin/pages/product/vendor/VendorList')),
        roles: ['user'],
    },
    {
        path: 'products/vendors/create',
        component: lazy(() => import('@/admin/pages/product/vendor/VendorForm')),
        roles: ['user'],
    },
    {
        path: 'products/vendors/:id/edit',
        component: lazy(() => import('@/admin/pages/product/vendor/VendorForm')),
        roles: ['user'],
    },
    {
        path: 'categories',
        component: lazy(() => import('@/admin/pages/category/CategoryList')),
        roles: ['user'],
    },
    {
        path: 'categories/create',
        component: lazy(() => import('@/admin/pages/category/CategoryForm')),
        roles: ['user', 'admin'],
    },
    {
        path: 'categories/:id/edit',
        component: lazy(() => import('@/admin/pages/category/CategoryForm')),
        roles: ['user', 'admin'],
    },
    {
        path: 'users',
        component: lazy(() => import('@/admin/pages/user/UserList')),
        roles: ['admin'],
    },
    {
        path: 'users/create',
        component: lazy(() => import('@/admin/pages/user/UserForm')),
        roles: ['admin'],
    },
    {
        path: 'users/:id/edit',
        component: lazy(() => import('@/admin/pages/user/UserForm')),
        roles: ['admin'],
    },
    {
        path: 'settings',
        component: lazy(() => import('@/admin/pages/setting/SettingList')),
        roles: ['admin'],
    },
    {
        path: 'settings/create',
        component: lazy(() => import('@/admin/pages/setting/SettingForm')),
        roles: ['admin'],
    },
    {
        path: 'settings/:id/edit',
        component: lazy(() => import('@/admin/pages/setting/SettingForm')),
        roles: ['admin'],
    },
    {
        path: 'tags',
        component: lazy(() => import('@/admin/pages/tag/TagList')),
        roles: ['admin'],
    },
    {
        path: 'tags/create',
        component: lazy(() => import('@/admin/pages/tag/TagForm')),
        roles: ['admin'],
    },
    {
        path: 'tags/:id/edit',
        component: lazy(() => import('@/admin/pages/tag/TagForm')),
        roles: ['admin'],
    },
    {
        path: 'carriers',
        component: lazy(() => import('@/admin/pages/carrier/CarrierList')),
        roles: ['admin'],
    },
    {
        path: 'carriers/create',
        component: lazy(() => import('@/admin/pages/carrier/CarrierForm')),
        roles: ['admin'],
    },
    {
        path: 'carriers/:id/edit',
        component: lazy(() => import('@/admin/pages/carrier/CarrierForm')),
        roles: ['admin'],
    },
    {
        path: 'delivery-time',
        component: lazy(() => import('@/admin/pages/delivery-time/DeliveryTimeList')),
        roles: ['admin'],
    },
    {
        path: 'delivery-time/create',
        component: lazy(() => import('@/admin/pages/delivery-time/DeliveryTimeForm')),
        roles: ['admin'],
    },
    {
        path: 'delivery-time/:id/edit',
        component: lazy(() => import('@/admin/pages/delivery-time/DeliveryTimeForm')),
        roles: ['admin'],
    },
    {
        path: 'currencies',
        component: lazy(() => import('@/admin/pages/currency/CurrencyList')),
        roles: ['admin'],
    },
    {
        path: 'currencies/create',
        component: lazy(() => import('@/admin/pages/currency/CurrencyForm')),
        roles: ['admin'],
    },
    {
        path: 'currencies/:id/edit',
        component: lazy(() => import('@/admin/pages/currency/CurrencyForm')),
        roles: ['admin'],
    },
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
