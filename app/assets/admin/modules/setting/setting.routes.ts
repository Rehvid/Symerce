import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const settingRoutes: AdminRouteInterface[] = [
    {
        path: 'settings',
        component: lazy(() => import('@admin/modules/setting/pages/SettingList')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'settings/:id/edit',
        component: lazy(() => import('@admin/modules/setting/pages/SettingForm')),
        roles: [AdminRole.ADMIN],
    },
];
