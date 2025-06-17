import { ComponentType, LazyExoticComponent } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';

export interface AdminRouteInterface {
    path: string;
    component: LazyExoticComponent<ComponentType<any>>;
    roles: AdminRole[];
}
