import { LazyExoticComponent, ReactElement } from 'react';

export interface AdminRouteInterface {
  path: string;
  component: LazyExoticComponent<() => ReactElement>;
  roles: string[];
}
