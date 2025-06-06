import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const dashboardRoutes: AdminRouteInterface[] = [
    {
        path: 'dashboard',
        component: lazy(() => import('@admin/modules/dashboard/pages/Dashboard')),
        roles: [AdminRole.ADMIN],
    },
]
