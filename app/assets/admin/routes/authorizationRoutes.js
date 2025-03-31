import {Route} from "react-router-dom";
import RegisterPage from "@/admin/pages/Auth/RegisterPage";
import LoginPage from "@/admin/pages/Auth/LoginPage";
import PublicRoute from "@/admin/components/Route/PublicRoute";

const authorizationRoutes = (
    <>
        <Route
            path="/admin/register"
            element={
                <PublicRoute component={<RegisterPage />} redirectOnAuthSuccess="/admin/dashboard" />
            }
        />
        <Route
            path="/admin/login"
            element={
                <PublicRoute component={<LoginPage />} redirectOnAuthSuccess="/admin/dashboard" />
            }
        />
    </>
);

export default authorizationRoutes;
