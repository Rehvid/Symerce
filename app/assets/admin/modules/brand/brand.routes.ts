import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const brandRoutes: AdminRouteInterface[] = [
    {
        path: 'brands',
        component: lazy(() => import('@admin/modules/brand/pages/BrandList')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'brands/create',
        component: lazy(() => import('@admin/modules/brand/pages/BrandForm')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'brands/:id/edit',
        component: lazy(() => import('@admin/modules/brand/pages/BrandForm')),
        roles: [AdminRole.ADMIN],
    },
];
