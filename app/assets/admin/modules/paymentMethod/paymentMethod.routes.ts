import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const paymentMethodRoutes: AdminRouteInterface[] = [
  {
    path: 'payment-methods',
    component: lazy(() => import('@admin/modules/paymentMethod/pages/PaymentMethodList')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'payment-methods/create',
    component: lazy(() => import('@admin/modules/paymentMethod/pages/PaymentMethodForm')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'payment-methods/:id/edit',
    component: lazy(() => import('@admin/modules/paymentMethod/pages/PaymentMethodForm')),
    roles: [AdminRole.ADMIN],
  },
]
