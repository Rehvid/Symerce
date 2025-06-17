import { Route } from 'react-router-dom';
import ProtectedRoute from '@/admin/routes/ProtectedRoute';
import { paymentMethodRoutes } from '@admin/modules/paymentMethod/paymentMethod.routes';
import { userRoutes } from '@admin/modules/user/user.routes';
import { countryRoutes } from '@admin/modules/country/country.routes';
import { customerRoutes } from '@admin/modules/customer/customer.routes';
import { orderRoutes } from '@admin/modules/order/order.routes';
import { settingRoutes } from '@admin/modules/setting/setting.routes';
import { productRoutes } from '@admin/modules/product/product.routes';
import { currencyRoutes } from '@admin/modules/currency/currency.routes';
import { tagRoutes } from '@admin/modules/tag/tag.routes';
import { categoryRoutes } from '@admin/modules/category/category.routes';
import { brandRoutes } from '@admin/modules/brand/brand.routes';
import { warehouseRoutes } from '@admin/modules/warehouse/warehouse.routes';
import { carrierRoutes } from '@admin/modules/carrier/carrier.routes';
import { attributesRoutes } from '@admin/modules/attribute/attribute.routes';
import { attributeValuesRoutes } from '@admin/modules/attributeValue/attributeValue.routes';
import { cartRoutes } from '@admin/modules/cart/cart.routes';
import { dashboardRoutes } from '@admin/modules/dashboard/dashboard.routes';
import { profileRoutes } from '@admin/modules/profile/profile.routes';
import { AdminRouteInterface } from '@admin/common/interfaces/AdminRouteInterface';
import { AdminRole } from '@admin/common/enums/adminRole';

const routesConfig: AdminRouteInterface[] = [
    ...profileRoutes,
    ...dashboardRoutes,
    ...cartRoutes,
    ...attributesRoutes,
    ...attributeValuesRoutes,
    ...carrierRoutes,
    ...warehouseRoutes,
    ...brandRoutes,
    ...categoryRoutes,
    ...tagRoutes,
    ...currencyRoutes,
    ...productRoutes,
    ...settingRoutes,
    ...userRoutes,
    ...countryRoutes,
    ...paymentMethodRoutes,
    ...orderRoutes,
    ...customerRoutes,
];

const withProtection = (requiredRoles: AdminRole[], Component: AdminRouteInterface['component']) => (
    <ProtectedRoute requiredRoles={requiredRoles}>
        <Component />
    </ProtectedRoute>
);

const adminRoutes = routesConfig.map(({ path, component, roles }) => (
    <Route key={path} path={path} element={withProtection(roles, component)} />
));

export default adminRoutes;
