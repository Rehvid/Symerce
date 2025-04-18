import AppRouter from '@/admin/routes/Router';
import MainLayout from '@/admin/layouts/MainLayout';
import { ApiProvider } from '@/admin/store/ApiContext';
import { AuthProvider } from '@/admin/store/AuthContext';
import { UserProvider } from '@/admin/store/UserContext';
import { ErrorBoundary } from 'react-error-boundary';
import ErrorBoundaryFallback from '@/admin/pages/ErrorBoundaryFallback';

const App = () => {


    return (
        <UserProvider>
            <ApiProvider>
                <AuthProvider>
                  <ErrorBoundary FallbackComponent={ErrorBoundaryFallback}>
                    <MainLayout>
                        <AppRouter />
                    </MainLayout>
                  </ErrorBoundary>
                </AuthProvider>
            </ApiProvider>
        </UserProvider>
    );
};

export default App;
