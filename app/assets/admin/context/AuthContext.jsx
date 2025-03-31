import {createContext, useEffect, useState} from 'react';
import restApiClient from '../../shared/api/RestApiClient';
import { createApiConfig } from '@/shared/api/ApiConfig';

export const AuthContext = createContext({});

export const AuthProvider = ({ children }) => {
    const UNAUTHORIZED = 401;

    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [user, setUser] = useState({});
    const [isLoadingAuthorization, setIsLoadingAuthorization] = useState(true);

    const login = user => {
        setIsAuthenticated(true);
        setUser(user);
    };

    const logout = async onLogoutSuccess => {
        const config = createApiConfig('auth/logout', 'POST', true);
        const { data, errors } = await restApiClient().executeRequest(config);

        if (errors) {
            console.error(result.errors.message);
            return;
        }

        setIsAuthenticated(false);
        setUser({});
        if (onLogoutSuccess) {
            onLogoutSuccess();
        }
    };

    const verifyAuth = async () => {
        const config = createApiConfig('auth/verify', 'GET', true);
        const { data, errors } = await restApiClient().executeRequest(config);

        if (errors && errors.code === UNAUTHORIZED) {
            setIsAuthenticated(false);
            setIsLoadingAuthorization(false);
            return;
        }

        if (data) {
            setUser(data);
            setIsAuthenticated(true);
            setIsLoadingAuthorization(false);
        }
    }



    return <AuthContext.Provider value={{
            isAuthenticated,
            setIsAuthenticated,
            login,
            logout,
            user,
            setUser,
            isLoadingAuthorization,
            verifyAuth,
        }}
    >
        {children}
    </AuthContext.Provider>;
};
