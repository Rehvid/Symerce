import { createContext } from 'react';

export const DataContext = createContext({});

export const DataProvider = ({ children }) => {
    const data = window.data;
    const currency = data.settings?.find((setting) => setting.type === 'currency')?.value;

    return <DataContext.Provider value={{ data, currency }}>{children}</DataContext.Provider>;
};
