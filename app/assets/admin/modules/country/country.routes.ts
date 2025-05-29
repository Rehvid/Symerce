import { AdminRouteInterface } from '@admin/shared/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/shared/enums/adminRole';

export const countryRoutes: AdminRouteInterface[] = [
  {
    path: 'countries',
    component: lazy(() => import('@admin/modules/country/pages/CountryListPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'countries/create',
    component: lazy(() => import('@admin/modules/country/pages/CountryFormPage')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'countries/:id/edit',
    component: lazy(() => import('@admin/modules/country/pages/CountryFormPage')),
    roles: [AdminRole.ADMIN],
  },
]
