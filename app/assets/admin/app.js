import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import ProtectedRoute from './components/Route/ProtectedRoute';
import {ApiProvider} from "@/admin/context/ApiContext";
import authorizationRoutes from "@/admin/routes/authorizationRoutes";
import AppLayout from "@/admin/components/Layout/AppLayout";
import adminRoutes from "@/admin/routes/adminRoutes";
import NotFoundPage from "@/admin/pages/NotFoundPage";
import ForbiddenPage from "@/admin/pages/ForbiddenPage";

function App() {
    return (
        <AuthProvider>
            <ApiProvider>
                <section className="bg-slate-100 min-h-screen">
                    <BrowserRouter>
                        <Routes>
                            {authorizationRoutes}
                            <Route
                                path="/admin"
                                element={<AppLayout />}
                            >
                                {adminRoutes}
                            </Route>
                            <Route path="/admin/forbidden" element={<ForbiddenPage />} />
                            <Route path="*" element={<NotFoundPage />} />
                        </Routes>
                    </BrowserRouter>
                </section>
            </ApiProvider>
        </AuthProvider>
    );
}

export default App;
