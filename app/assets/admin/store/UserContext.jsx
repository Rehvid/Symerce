import { createContext, useState } from 'react';

export const UserContext = createContext({});

export const UserProvider = ({ children }) => {
    const [user, setUser] = useState({});
    const [isAuthenticated, setIsAuthenticated] = useState(false);

    return (
        <UserContext.Provider value={{ user, setUser, isAuthenticated, setIsAuthenticated }}>
            {children}
        </UserContext.Provider>
    );
};
