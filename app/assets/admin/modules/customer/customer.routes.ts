import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const customerRoutes: AdminRouteInterface[] = [
  {
    path: 'customers',
    component: lazy(() => import('@admin/modules/customer/pages/CustomerList')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'customers/create',
    component: lazy(() => import('@admin/modules/customer/pages/CustomerForm')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'customers/:id/edit',
    component: lazy(() => import('@admin/modules/customer/pages/CustomerForm')),
    roles: [AdminRole.ADMIN],
  },
]
