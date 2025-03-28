import {createContext, useCallback, useState} from "react";
import restApiClient from "@/shared/api/RestApiClient";
import {useAuth} from "@/admin/hooks/useAuth";
import {useNavigate} from "react-router-dom";

export const ApiContext = createContext(null);

export const ApiProvider = ({children}) => {
    const { logout, isAuthenticated } = useAuth();
    const [isLoading, setIsLoading] = useState(false);

    const executeRequest = useCallback(async (apiConfig, requestData = {}) => {
        if (!apiConfig || !apiConfig.getConfig || typeof apiConfig.getConfig !== 'function') {
            throw new Error('Invalid apiConfig. Must be created using createApiConfig.');
        }
       setIsLoading(true);
        const {data, errors, meta} = await restApiClient().executeRequest(apiConfig, requestData);

        if (errors && errors.code === 401) {
            logout(() => window.href = 'admin/login');
        }

        setIsLoading(false);
        return {
            data: data || {},
            meta: meta || null,
            errors: errors || null,
        };
    }, [isAuthenticated]);

    return (
        <ApiContext.Provider value={{logout, executeRequest, isLoading, setIsLoading}}>
            {children}
        </ApiContext.Provider>
    )
}
