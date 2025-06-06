import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';


export const profileRoutes: AdminRouteInterface[] = [
    {
        path: 'profile',
        component: lazy(() => import('@admin/modules/profile/pages/Profile')),
        roles: [AdminRole.ADMIN],
    },
]
