import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

const formComponent = lazy(() => import('@admin/modules/currency/pages/CurrencyFormPage'));

export const currencyRoutes: AdminRouteInterface[] = [
    {
        path: 'currencies',
        component: lazy(() => import('@admin/modules/currency/pages/CurrencyListPage')),
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'currencies/create',
        component: formComponent,
        roles: [AdminRole.ADMIN],
    },
    {
        path: 'currencies/:id/edit',
        component: formComponent,
        roles: [AdminRole.ADMIN],
    },
];
