import { ComponentType, LazyExoticComponent } from 'react';

export interface AdminRouteInterface {
    path: string;
    component: LazyExoticComponent<ComponentType<any>>;
    roles: string[];
}
