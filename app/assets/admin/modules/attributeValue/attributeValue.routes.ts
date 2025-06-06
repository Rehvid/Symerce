import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const attributeValuesRoutes: AdminRouteInterface[] = [
  {
    path: 'products/attributes/:attributeId/values',
    component: lazy(() => import('@admin/modules/attributeValue/pages/AttributeValueList')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'products/attributes/:attributeId/values/create',
    component: lazy(() => import('@admin/modules/attributeValue/pages/AttributeValueForm')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'products/attributes/:attributeId/values/:id/edit',
    component: lazy(() => import('@admin/modules/attributeValue/pages/AttributeValueForm')),
    roles: [AdminRole.ADMIN],
  },
]
