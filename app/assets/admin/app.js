import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import PrivateRoute from './components/PrivateRoute';
import RegisterPage from './pages/Auth/RegisterPage';
import LoginPage from './pages/Auth/LoginPage';
import DashboardPage from './pages/DashboardPage';
import AppLayout from './components/Layout/AppLayout';
import ProductPage from './pages/Product/ProductPage';
import CategoryPage from './pages/Category/CategoryPage';
import CategoryFormPage from './pages/Category/CategoryFormPage';
import {ApiProvider} from "@/admin/context/ApiContext";

function App() {
    return (
        <AuthProvider>
            <ApiProvider>
                <section className="bg-slate-100 h-screen">
                    <BrowserRouter>
                        <Routes>
                            <Route
                                path="/admin/register"
                                element={
                                    <PrivateRoute component={<RegisterPage />} redirectOnAuthSuccess="/admin/dashboard" />
                                }
                            />
                            <Route
                                path="/admin/login"
                                element={
                                    <PrivateRoute component={<LoginPage />} redirectOnAuthSuccess="/admin/dashboard" />
                                }
                            />
                            <Route
                                path="/admin"
                                element={<PrivateRoute redirectOnAuthFailure="/admin/login" component={<AppLayout />} />}
                            >
                                <Route path="dashboard" element={<DashboardPage />} />
                                <Route path="products" element={<ProductPage />} />
                                <Route path="categories" element={<CategoryPage />} />
                                <Route path="categories/create" element={<CategoryFormPage />} />
                                <Route path="categories/:id/edit" element={<CategoryFormPage />} />
                            </Route>
                        </Routes>
                    </BrowserRouter>
                </section>
            </ApiProvider>
        </AuthProvider>
    );
}

export default App;
