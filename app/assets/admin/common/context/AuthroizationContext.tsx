import React, { createContext, ReactNode, useContext, useState } from 'react';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { useUser } from '@admin/common/context/UserContext';
import { HttpMethod } from '@admin/common/enums/httpEnums';

interface AuthContextInterface {
    login: (user: any) => void;
    logout: (onLogoutSuccess?: () => void) => Promise<void>;
    verifyAuth: () => Promise<void>;
    isLoadingAuthorization: boolean;
}

const AuthContext = createContext<AuthContextInterface | undefined>(undefined);

interface AuthProviderProps {
    children: ReactNode;
}

export const AuthorizationProvider: React.FC<AuthProviderProps> = ({ children }) => {
    const { setUser, setIsAuthenticated } = useUser();
    const { handleApiRequest } = useAdminApi();
    const [isLoadingAuthorization, setIsLoadingAuthorization] = useState(true);

    const login = (user: any) => {
        setIsAuthenticated(true);
        setUser(user);
    };

    const logout = async (onLogoutSuccess?: () => void) => {
        await handleApiRequest(HttpMethod.POST, 'admin/auth/logout', {
            onSuccess: () => {
                setIsAuthenticated(false);
                setUser({});
                onLogoutSuccess?.();
            },
            onError: (errors) => {
                console.error('Logout error:', errors);
            },
        });
    };

    const verifyAuth = async () => {
        await handleApiRequest(HttpMethod.GET, 'admin/auth/verify', {
            onSuccess: (data: { user: any }) => {
                if (data?.user) {
                    setUser(data.user);
                    setIsAuthenticated(true);
                }
            },
            onError: (errors) => {
                console.error('Verify auth error:', errors);
            },
            onFinally: () => {
                setIsLoadingAuthorization(false);
            }
        })
    };

    return (
        <AuthContext.Provider value={{ login, logout, verifyAuth, isLoadingAuthorization }}>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = (): AuthContextInterface => {
    const context = useContext(AuthContext);
    if (!context) {
        throw new Error('useAuth must be used within an AuthProvider');
    }
    return context;
};
