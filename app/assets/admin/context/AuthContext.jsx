import { createContext, useState, useContext, useEffect } from 'react';
import restApiClient from '../../shared/api/RestApiClient';

const AuthContext = createContext({});
export const AuthProvider = ({ children }) => {
    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [loading, setLoading] = useState(true);
    const [user, setUser] = useState({});

    const login = user => {
        setIsAuthenticated(true);
        setUser(user);
    };

    const logout = onLogoutSuccess => {
        const config = restApiClient().createConfig('auth/logout', 'POST');

        restApiClient()
            .sendRequest(config)
            .then(response => {
                const { success } = response;
                if (!success) {
                    return;
                }

                setIsAuthenticated(false);
                if (onLogoutSuccess) {
                    onLogoutSuccess();
                }
            });
    };

    const checkAuth = async () => {
        const config = restApiClient().createConfig('auth/check-auth', 'GET', { credentials: 'include' });

        try {
            const { authenticated, user } = await restApiClient().sendRequest(config);
            authenticated ? login(user) : setIsAuthenticated(false);
            setLoading(false);
        } catch (e) {
            setIsAuthenticated(false);
            setLoading(false);
        }
    };

    useEffect(() => {
        (async () => {
            await checkAuth();
        })();
    }, []);

    return (
        <AuthContext.Provider value={{ isAuthenticated, loading, login, logout, user }}>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = () => useContext(AuthContext);
