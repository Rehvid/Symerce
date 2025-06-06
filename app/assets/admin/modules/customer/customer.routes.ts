import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const customerRoutes: AdminRouteInterface[] = [
  {
    path: 'customers',
    component: lazy(() => import('@admin/modules/customer/pages/CustomerListPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'customers/create',
    component: lazy(() => import('@admin/modules/customer/pages/CustomerFormPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'customers/:id/edit',
    component: lazy(() => import('@admin/modules/customer/pages/CustomerFormPage')),
    roles: [AdminRole.ADMIN],
  },
]
