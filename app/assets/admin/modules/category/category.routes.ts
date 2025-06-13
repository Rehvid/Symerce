import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const categoryRoutes: AdminRouteInterface[] = [
    {
        path: 'categories',
        component: lazy(() => import('@admin/modules/category/pages/CategoryList')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'categories/create',
        component: lazy(() => import('@admin/modules/category/pages/CategoryForm')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'categories/:id/edit',
        component: lazy(() => import('@admin/modules/category/pages/CategoryForm')),
        roles: [AdminRole.ADMIN],
    },
];
