import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import PrivateRoute from './components/PrivateRoute';
import RegisterPage from './pages/Auth/RegisterPage';
import LoginPage from './pages/Auth/LoginPage';
import DashboardPage from './pages/DashboardPage';

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
                            path="/admin/dashboard"
                            element={
                                <PrivateRoute component={<DashboardPage />} redirectOnAuthFailure="/admin/login" />
                            }
                        />
                    </Routes>
                </BrowserRouter>
            </section>
        </AuthProvider>
    );
}

export default App;
