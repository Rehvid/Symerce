import { AdminRouteInterface } from '@admin/shared/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/shared/enums/adminRole';


export const orderRoutes: AdminRouteInterface[] = [
  {
    path: 'orders',
    component: lazy(() => import('@admin/modules/order/pages/OrderListPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'orders/create',
    component: lazy(() => import('@admin/modules/order/pages/OrderFormPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'orders/:id/edit',
    component: lazy(() => import('@admin/modules/order/pages/OrderFormPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'orders/:id/details',
    component: lazy(() => import('@admin/modules/order/pages/OrderDetailPage')),
    roles: [AdminRole.ADMIN],
  },
]
