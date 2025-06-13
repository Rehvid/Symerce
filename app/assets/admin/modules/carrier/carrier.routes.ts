import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const carrierRoutes: AdminRouteInterface[] = [
    {
        path: 'carriers',
        component: lazy(() => import('@admin/modules/carrier/pages/CarrierList')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'carriers/create',
        component: lazy(() => import('@admin/modules/carrier/pages/CarrierForm')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'carriers/:id/edit',
        component: lazy(() => import('@admin/modules/carrier/pages/CarrierForm')),
        roles: [AdminRole.ADMIN],
    },
];
