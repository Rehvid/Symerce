import { createContext, useCallback, useState } from 'react';
import restApiClient from '@/shared/api/RestApiClient';
import { useAuth } from '@/admin/hooks/useAuth';
import { HTTP_STATUS_CODES } from '@/admin/constants/httpConstants';
import { useUser } from '@/admin/hooks/useUser';

export const ApiContext = createContext(null);

export const ApiProvider = ({ children }) => {
    const { setIsAuthenticated, setUser } = useUser();
    const [isRequestFinished, setIsRequestFinished] = useState(false);
    const handleApiRequest = async (apiConfig, { onSuccess, onError, onNetworkError }) => {
        setIsRequestFinished(false);
        try {
            const { data, errors, meta } = await restApiClient().sendApiRequest(apiConfig, {
                onUnauthorized: () => {
                    setIsAuthenticated(false);
                    setUser(null);
                },
            });

            if (errors && Object.values(errors).length > 0) {
                setIsRequestFinished(true);
                return onError?.(errors);
            }

            setIsRequestFinished(true);
            return onSuccess?.(data, meta);
        } catch (e) {
            console.error('Network error:', e);
            setIsRequestFinished(true);
            return onNetworkError?.(e);
        }
    };

    return <ApiContext.Provider value={{ handleApiRequest, isRequestFinished }}>{children}</ApiContext.Provider>;
};
