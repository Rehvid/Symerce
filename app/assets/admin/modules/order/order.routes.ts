import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const orderRoutes: AdminRouteInterface[] = [
    {
        path: 'orders',
        component: lazy(() => import('@admin/modules/order/pages/OrderList')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'orders/create',
        component: lazy(() => import('@admin/modules/order/pages/OrderForm')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'orders/:id/edit',
        component: lazy(() => import('@admin/modules/order/pages/OrderForm')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'orders/:id/details',
        component: lazy(() => import('@admin/modules/order/pages/OrderDetail')),
        roles: [AdminRole.ADMIN],
    },
];
