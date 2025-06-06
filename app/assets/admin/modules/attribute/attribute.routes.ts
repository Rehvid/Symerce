import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

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
