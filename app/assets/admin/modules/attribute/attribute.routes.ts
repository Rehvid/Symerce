import { AdminRouteInterface } from '@admin/shared/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/shared/enums/adminRole';

export const attributesRoutes: AdminRouteInterface[] = [
  {
    path: 'products/attributes',
    component: lazy(() => import('@admin/modules/attribute/pages/AttributeList')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'products/attributes/create',
    component: lazy(() => import('@admin/modules/attribute/pages/AttributeForm')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'products/attributes/:id/edit',
    component: lazy(() => import('@admin/modules/attribute/pages/AttributeForm')),
    roles: [AdminRole.ADMIN],
  },
]
