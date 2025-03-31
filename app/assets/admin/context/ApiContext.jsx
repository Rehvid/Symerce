import {createContext, useCallback, useState} from "react";
import restApiClient from "@/shared/api/RestApiClient";
import {useAuth} from "@/admin/hooks/useAuth";

export const ApiContext = createContext(null);

export const ApiProvider = ({children}) => {
    const UNAUTHORIZED = 401;
    const { setIsAuthenticated, setUser } = useAuth();
    const [isRequestFinished, setIsRequestFinished] = useState(false);

    const executeRequest = async (apiConfig, requestData = {}) => {
        if (!apiConfig || !apiConfig.getConfig || typeof apiConfig.getConfig !== 'function') {
            throw new Error('Invalid apiConfig. Must be created using createApiConfig.');
        }

        setIsRequestFinished(false);

        const {data, errors, meta} = await restApiClient().executeRequest(apiConfig, requestData);

        if (errors && errors.code === UNAUTHORIZED) {
           setIsAuthenticated(false);
           setUser(false);
        }

        setIsRequestFinished(true);
        return {
            data: data || {},
            meta: meta || null,
            errors: errors || null,
        };
    };

    return (
        <ApiContext.Provider value={{executeRequest, isRequestFinished}}>
            {children}
        </ApiContext.Provider>
    )
}
