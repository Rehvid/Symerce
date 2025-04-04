import { createContext, useState } from 'react';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { useApi } from '@/admin/hooks/useApi';
import { useUser } from '@/admin/hooks/useUser';

export const AuthContext = createContext({});

export const AuthProvider = ({ children }) => {
    const { handleApiRequest } = useApi();
    const { setUser, setIsAuthenticated } = useUser();
    const [isLoadingAuthorization, setIsLoadingAuthorization] = useState(true);

    const login = (user) => {
        setIsAuthenticated(true);
        setUser(user);
    };

    const logout = async (onLogoutSuccess) => {
        const apiConfig = createApiConfig('auth/logout', HTTP_METHODS.POST);

        handleApiRequest(apiConfig, {
            onSuccess: () => {
                setIsAuthenticated(false);
                setUser({});
                onLogoutSuccess?.();
            },
            onError: (errors) => {
                console.error(errors);
            },
        });
    };

    const verifyAuth = async () => {
        const apiConfig = createApiConfig('auth/verify', HTTP_METHODS.GET);
        handleApiRequest(apiConfig, {
            onSuccess: (data) => {
                setUser(data.user);
                setIsAuthenticated(true);
                setIsLoadingAuthorization(false);
            },
            onError: (errors) => {
                console.log(errors);
                setIsLoadingAuthorization(false);
            },
        });
    };

    return (
        <AuthContext.Provider value={{ login, logout, verifyAuth, isLoadingAuthorization }}>
            {children}
        </AuthContext.Provider>
    );
};
