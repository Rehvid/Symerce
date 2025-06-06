import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

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
