import {Route} from "react-router-dom";
import ProfilePage from "@/admin/pages/Profile/ProfilePage";
import DashboardPage from "@/admin/pages/DashboardPage";
import ProductPage from "@/admin/pages/Product/ProductPage";
import CategoryPage from "@/admin/pages/Category/CategoryPage";
import CategoryFormPage from "@/admin/pages/Category/CategoryFormPage";
import ProtectedRoute from "@/admin/components/Route/ProtectedRoute";

const withProtection = (requiredRoles, children) => (
    <ProtectedRoute requiredRoles={requiredRoles}>
        {children}
    </ProtectedRoute>
)


const adminRoutes = (
    <>
        <Route path="profile" element={withProtection(['user'], <ProfilePage/>)} />
        <Route path="dashboard" element={withProtection(['user'], <DashboardPage />)} />
        <Route path="products" element={withProtection(['user', 'seo'], <ProductPage />)} />
        <Route path="categories" element={withProtection(['user'], <CategoryPage />)} />
        <Route path="categories/create" element={withProtection(['user', 'admin'], <CategoryFormPage />)} />
        <Route path="categories/:id/edit" element={withProtection(['user', 'admin'], <CategoryFormPage />)} />
    </>
);

export default adminRoutes;
