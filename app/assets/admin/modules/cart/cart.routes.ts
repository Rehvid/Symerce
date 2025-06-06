import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';


export const cartRoutes: AdminRouteInterface[] = [
  {
    path: 'carts',
    component: lazy(() => import('@admin/modules/cart/pages/CartList')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'carts/:id/details',
    component: lazy(() => import('@admin/modules/cart/pages/CartDetail')),
    roles: [AdminRole.ADMIN],
  },
]
