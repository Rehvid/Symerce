import { AdminRouteInterface } from '@admin/shared/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/shared/enums/adminRole';

export const tagRoutes: AdminRouteInterface[] = [
  {
    path: 'tags',
    component: lazy(() => import('@admin/modules/tag/pages/TagListPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'tags/create',
    component: lazy(() => import('@admin/modules/tag/pages/TagFormPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'tags/:id/edit',
    component: lazy(() => import('@admin/modules/tag/pages/TagFormPage')),
    roles: [AdminRole.ADMIN],
  },
]
