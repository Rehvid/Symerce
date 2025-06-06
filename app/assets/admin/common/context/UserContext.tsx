import React, { createContext, Dispatch, ReactNode, SetStateAction, useContext, useState } from 'react';
import { AdminRole } from '@admin/common/enums/adminRole';
import { FileResponseInterface } from '@admin/common/interfaces/FileResponseInterface';

export interface User {
    id?: string | number;
    firstname?: string;
    surname?: string;
    fullName?: string;
    email?: string;
    roles?: AdminRole[];
    avatar?: FileResponseInterface
    [key: string]: any;
}

interface UserContextInterface {
    user: User;
    setUser: Dispatch<SetStateAction<User>>;
    isAuthenticated: boolean;
    setIsAuthenticated: Dispatch<SetStateAction<boolean>>;
}

export const UserContext = createContext<UserContextInterface | undefined>(undefined);

interface UserProviderProps {
    children: ReactNode;
}

export const UserProvider: React.FC<UserProviderProps> = ({ children }) => {
    const [user, setUser] = useState<User>({} as User);
    const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);

    return (
        <UserContext.Provider value={{ user, setUser, isAuthenticated, setIsAuthenticated }}>
            {children}
        </UserContext.Provider>
    );
};

export const useUser = (): UserContextInterface => {
    const context = useContext(UserContext);
    if (!context) {
        throw new Error('useUser must be used within a UserProvider');
    }
    return context;
};
