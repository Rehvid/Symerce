import { createContext, useState, useContext} from 'react';
import restApiClient from "../../shared/api/RestApiClient";
import {createApiConfig} from "../../shared/api/ApiConfig";

const AuthContext = createContext({});

export const AuthProvider = ({ children }) => {
    const [isAuthenticated, setIsAuthenticated] = useState(true);
    const [user, setUser] = useState({});

    const login = user => {
        setIsAuthenticated(true);
        setUser(user);
    };

    const logout = async (onLogoutSuccess) => {
        const config = createApiConfig('auth/logout', 'POST', true);
        const { data, errors} = await restApiClient().executeRequest(config);

        if (errors) {
            console.error(result.errors.message);
            return;
        }

        if (data.success) {
            setIsAuthenticated(false);
            setUser({});
            if (onLogoutSuccess) {
                onLogoutSuccess();
            }
        }
    };

    return (
        <AuthContext.Provider value={{ isAuthenticated, login, logout, user }}>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = () => useContext(AuthContext);
