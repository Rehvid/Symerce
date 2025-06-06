import React, { createContext, ReactNode, useContext } from 'react';

interface Setting {
    settingKey: string;
    value: string;
}

interface AppData {
    settings?: Setting[];
    [key: string]: any;
}

interface AppDataContextInterface {
    data: AppData;
    currency?: Currency|undefined;
}

interface Currency {
    code: string;
    id: number;
    name: string;
    roundingPrecision: number;
    symbol: string
}

const AppDataContext = createContext<AppDataContextInterface | undefined>(undefined);

interface AppDataProviderProps {
    children: ReactNode;
}

export const AppDataProvider: React.FC<AppDataProviderProps> = ({ children }) => {
    const data = (window as any).data as AppData;
    const currency  = data.settings?.find(setting => setting.settingKey === 'currency')?.value;

    return (
        <AppDataContext.Provider value={{ data, currency }}>
            {children}
        </AppDataContext.Provider>
    );
};

export const useAppData = (): AppDataContextInterface => {
    const context = useContext(AppDataContext);
    if (!context) {
        throw new Error('useAppData must be used within an AppDataProvider');
    }
    return context;
};
