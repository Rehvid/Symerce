import { AdminRouteInterface } from '@admin/shared/interfaces/AdminRouteInterface';
import { lazy } from 'react';

export const paymentMethodRoutes: AdminRouteInterface[] = [
  {
    path: 'payment-methods',
    component: lazy(() => import('@admin/modules/paymentMethod/pages/PaymentMethodListPage')),
    roles: ['admin'],
  },
  {
    path: 'payment-methods/create',
    component: lazy(() => import('@admin/modules/paymentMethod/pages/PaymentMethodFormPage')),
    roles: ['admin'],
  },
  {
    path: 'payment-methods/:id/edit',
    component: lazy(() => import('@admin/modules/paymentMethod/pages/PaymentMethodFormPage')),
    roles: ['admin'],
  },
]
