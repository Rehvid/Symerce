import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { lazy } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export const countryRoutes: AdminRouteInterface[] = [
  {
    path: 'countries',
    component: lazy(() => import('@admin/modules/country/pages/CountryList')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'countries/create',
    component: lazy(() => import('@admin/modules/country/pages/CountryForm')),
    roles: [AdminRole.ADMIN],
  },
  {
    path: 'countries/:id/edit',
    component: lazy(() => import('@admin/modules/country/pages/CountryForm')),
    roles: [AdminRole.ADMIN],
  },
]
