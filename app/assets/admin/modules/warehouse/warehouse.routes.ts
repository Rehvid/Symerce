import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const warehouseRoutes: AdminRouteInterface[] = [
  {
    path: 'warehouses',
    component: lazy(() => import('@admin/modules/warehouse/pages/WarehouseList')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'warehouses/create',
    component: lazy(() => import('@admin/modules/warehouse/pages/WarehouseForm')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'warehouses/:id/edit',
    component: lazy(() => import('@admin/modules/warehouse/pages/WarehouseForm')),
    roles: [AdminRole.ADMIN],
  },
]
