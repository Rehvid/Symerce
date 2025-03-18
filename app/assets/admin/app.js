import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import PrivateRoute from './components/PrivateRoute';
import RegisterPage from './pages/Auth/RegisterPage';
import LoginPage from './pages/Auth/LoginPage';
import DashboardPage from './pages/DashboardPage';
import AppLayout from './components/Layout/AppLayout';
import ProductPage from './pages/Product/ProductPage';

function App() {
    return (
        <AuthProvider>
            <section className="bg-gray-100 h-screen">
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
                            <Route path="product" element={<ProductPage />} />
                        </Route>
                    </Routes>
                </BrowserRouter>
            </section>
        </AuthProvider>
    );
}

export default App;
