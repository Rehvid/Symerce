import { createContext, useState, useContext } from 'react';
import restApiClient from '../../shared/api/RestApiClient';
import { createApiConfig } from '../../shared/api/ApiConfig';

export const AuthContext = createContext({});

export const AuthProvider = ({ children }) => {
    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [user, setUser] = useState({});

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

        // console.log(data);
        // if (data.success) {
            setIsAuthenticated(false);
            setUser({});
            if (onLogoutSuccess) {
                onLogoutSuccess();
            }
        // }
    };

    return <AuthContext.Provider value={{ isAuthenticated, login, logout, user }}>{children}</AuthContext.Provider>;
};
