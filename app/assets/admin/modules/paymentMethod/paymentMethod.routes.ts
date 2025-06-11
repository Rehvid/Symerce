import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';

export const paymentMethodRoutes: AdminRouteInterface[] = [
  {
    path: 'payment-methods',
    component: lazy(() => import('@admin/modules/paymentMethod/pages/PaymentMethodList')),
    roles: ['admin'],
  },
  {
    path: 'payment-methods/create',
    component: lazy(() => import('@admin/modules/paymentMethod/pages/PaymentMethodForm')),
    roles: ['admin'],
  },
  {
    path: 'payment-methods/:id/edit',
    component: lazy(() => import('@admin/modules/paymentMethod/pages/PaymentMethodForm')),
    roles: ['admin'],
  },
]
