import { AdminRouteInterface } from '@admin/shared/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/shared/enums/adminRole';

export const userRoutes: AdminRouteInterface[] = [
  {
    path: 'users',
    component: lazy(() => import('@admin/modules/user/pages/UserListPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'users/create',
    component: lazy(() => import('@admin/modules/user/pages/UserFormPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'users/:id/edit',
    component: lazy(() => import('@admin/modules/user/pages/UserFormPage')),
    roles: [AdminRole.ADMIN],
  },
]
