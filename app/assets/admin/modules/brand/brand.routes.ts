import { AdminRouteInterface } from '@admin/shared/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/shared/enums/adminRole';

export const brandRoutes: AdminRouteInterface[] = [
  {
    path: 'brands',
    component: lazy(() => import('@admin/modules/brand/pages/BrandListPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'brands/create',
    component: lazy(() => import('@admin/modules/brand/pages/BrandFormPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'brands/:id/edit',
    component: lazy(() => import('@admin/modules/brand/pages/BrandFormPage')),
    roles: [AdminRole.ADMIN],
  },
]
