import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const productRoutes: AdminRouteInterface[] = [
  {
    path: 'products',
    component: lazy(() => import('@admin/modules/product/pages/ProductListPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'products/create',
    component: lazy(() => import('@admin/modules/product/pages/ProductFormPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'products/:id/edit',
    component: lazy(() => import('@admin/modules/product/pages/ProductFormPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'products/:id/price-history',
    component: lazy(() => import('@admin/modules/product/pages/ProductPriceHistory')),
    roles: [AdminRole.ADMIN],
  },
]
