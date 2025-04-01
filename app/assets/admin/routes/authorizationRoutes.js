import {Route} from "react-router-dom";
import RegisterPage from "@/admin/pages/Auth/RegisterPage";
import LoginPage from "@/admin/pages/Auth/LoginPage";

const authorizationRoutes = (
    <>
        <Route
            path="/admin/register"
            element={<RegisterPage />}
        />
        <Route
            path="/admin/login"
            element={<LoginPage />}
        />
    </>
);

export default authorizationRoutes;
