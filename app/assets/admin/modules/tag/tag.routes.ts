import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const tagRoutes: AdminRouteInterface[] = [
    {
        path: 'tags',
        component: lazy(() => import('@admin/modules/tag/pages/TagList')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'tags/create',
        component: lazy(() => import('@admin/modules/tag/pages/TagForm')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'tags/:id/edit',
        component: lazy(() => import('@admin/modules/tag/pages/TagForm')),
        roles: [AdminRole.ADMIN],
    },
];
