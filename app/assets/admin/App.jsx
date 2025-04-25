import AppRouter from '@/admin/routes/Router';
import MainLayout from '@/admin/layouts/MainLayout';
import { ApiProvider } from '@/admin/store/ApiContext';
import { AuthProvider } from '@/admin/store/AuthContext';
import { UserProvider } from '@/admin/store/UserContext';
import { ErrorBoundary } from 'react-error-boundary';
import ErrorBoundaryFallback from '@/admin/pages/ErrorBoundaryFallback';
import { DataProvider } from '@/admin/store/DataContext';

const App = () => {
    return (
      <DataProvider>
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
      </DataProvider>
    );
};

export default App;
