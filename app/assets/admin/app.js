import AppRouter from '@/admin/routes/Router';
import MainLayout from '@/admin/layouts/MainLayout';
import { ApiProvider } from '@/admin/store/ApiContext';
import { AuthProvider } from '@/admin/store/AuthContext';
import { UserProvider } from '@/admin/store/UserContext';

const App = () => {
    return (
        <UserProvider>
            <ApiProvider>
                <AuthProvider>
                    <MainLayout>
                        <AppRouter />
                    </MainLayout>
                </AuthProvider>
            </ApiProvider>
        </UserProvider>
    );
};

export default App;
