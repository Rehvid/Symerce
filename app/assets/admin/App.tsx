import React, { ReactElement } from 'react';
import AppRouter from '@/admin/routes/Router';
import MainLayout from '@/admin/layouts/MainLayout';
import { ErrorBoundary } from 'react-error-boundary';
import ErrorBoundaryFallback from '@/admin/pages/ErrorBoundaryFallback';
import { AdminApiProvider } from '@admin/common/context/AdminApiContext';
import { UserProvider } from '@admin/common/context/UserContext';
import { AppDataProvider } from '@admin/common/context/AppDataContext';
import { AuthorizationProvider } from '@admin/common/context/AuthroizationContext';

const App = (): ReactElement => {
    return (
        <AppDataProvider>
            <UserProvider>
                <AdminApiProvider baseUrl={process.env.REACT_APP_API_URL || ''}>
                    <AuthorizationProvider>
                        <ErrorBoundary FallbackComponent={ErrorBoundaryFallback}>
                            <MainLayout>
                                <AppRouter />
                            </MainLayout>
                        </ErrorBoundary>
                    </AuthorizationProvider>
                </AdminApiProvider>
            </UserProvider>
        </AppDataProvider>
    );
};

export default App;
