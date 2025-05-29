import { AdminRouteInterface } from '@admin/shared/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/shared/enums/adminRole';

export const settingRoutes: AdminRouteInterface[] = [
  {
    path: 'settings',
    component: lazy(() => import('@admin/modules/setting/pages/SettingListPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'settings/create',
    component: lazy(() => import('@admin/modules/setting/pages/SettingFormPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'settings/:id/edit',
    component: lazy(() => import('@admin/modules/setting/pages/SettingFormPage')),
    roles: [AdminRole.ADMIN],
  },
]
