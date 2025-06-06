import { AdminRouteInterface } from '@admin/shared/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/shared/enums/adminRole';


export const profileRoutes: AdminRouteInterface[] = [
    {
        path: 'profile',
        component: lazy(() => import('@admin/modules/profile/pages/Profile')),
        roles: [AdminRole.ADMIN],
    },
]
