import { Route } from 'react-router-dom';
import { lazy } from 'react';
import ProtectedRoute from '@/admin/routes/ProtectedRoute';
import { paymentMethodRoutes } from '@admin/modules/paymentMethod/paymentMethod.routes';
import { userRoutes } from '@admin/modules/user/user.routes';
import { countryRoutes } from '@admin/modules/country/country.routes';
import { customerRoutes } from '@admin/modules/customer/customer.routes';
import { orderRoutes } from '@admin/modules/order/order.routes';
import { settingRoutes } from '@admin/modules/setting/setting.routes';
import { productRoutes } from '@admin/modules/product/product.routes';
import { currencyRoutes } from '@admin/modules/currency/currency.routes';

const routesConfig = [
    {
        path: 'profile',
        component: lazy(() => import('@/admin/pages/Profile')),
        roles: ['user', 'admin'],
    },
    {
        path: 'dashboard',
        component: lazy(() => import('@/admin/pages/Dashboard')),
        roles: ['user', 'admin'],
    },
    {
        path: 'products/attributes',
        component: lazy(() => import('@/admin/pages/product/attribute/AttributeList')),
        roles: ['user', 'admin'],
    },
    {
        path: 'products/attributes/create',
        component: lazy(() => import('@/admin/pages/product/attribute/AttributeForm')),
        roles: ['admin'],
    },
    {
        path: 'products/attributes/:id/edit',
        component: lazy(() => import('@/admin/pages/product/attribute/AttributeForm')),
        roles: ['admin'],
    },
    {
        path: 'products/attributes/:attributeId/values',
        component: lazy(() => import('@/admin/pages/product/attribute/attribute-value/AttributeValueList')),
        roles: ['user', 'admin'],
    },
    {
        path: 'products/attributes/:attributeId/values/create',
        component: lazy(() => import('@/admin/pages/product/attribute/attribute-value/AttributeValueForm')),
        roles: ['admin'],
    },
    {
        path: 'products/attributes/:attributeId/values/:id/edit',
        component: lazy(() => import('@/admin/pages/product/attribute/attribute-value/AttributeValueForm')),
        roles: ['admin'],
    },
    {
        path: 'products/vendors',
        component: lazy(() => import('@/admin/pages/product/vendor/VendorList')),
        roles: ['user', 'admin'],
    },
    {
        path: 'products/vendors/create',
        component: lazy(() => import('@/admin/pages/product/vendor/VendorForm')),
        roles: ['admin'],
    },
    {
        path: 'products/vendors/:id/edit',
        component: lazy(() => import('@/admin/pages/product/vendor/VendorForm')),
        roles: ['admin'],
    },
    {
        path: 'categories',
        component: lazy(() => import('@/admin/pages/category/CategoryList')),
        roles: ['user', 'admin'],
    },
    {
        path: 'categories/create',
        component: lazy(() => import('@/admin/pages/category/CategoryForm')),
        roles: ['admin'],
    },
    {
        path: 'categories/:id/edit',
        component: lazy(() => import('@/admin/pages/category/CategoryForm')),
        roles: ['user', 'admin'],
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
    ...currencyRoutes,
    ...productRoutes,
    ...settingRoutes,
    ...userRoutes,
    ...countryRoutes,
    ...paymentMethodRoutes,
    ...orderRoutes,
    ...customerRoutes
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
