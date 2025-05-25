import { createContext, useState } from 'react';
import restApiClient from '@/shared/api/RestApiClient';
import { useUser } from '@/admin/hooks/useUser';

export const ApiContext = createContext(null);

export const ApiProvider = ({ children }) => {
    const { setIsAuthenticated, setUser } = useUser();
    const [isRequestFinished, setIsRequestFinished] = useState(false);
    const handleApiRequest = async (apiConfig, { onSuccess, onError, onNetworkError, onFinally }) => {
        setIsRequestFinished(false);
        try {
            const { data, errors, meta, message } = await restApiClient().sendApiRequest(apiConfig, {
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
            return onSuccess?.({ data, meta, message });
        } catch (e) {
            console.error('Network error:', e);
            setIsRequestFinished(true);
            return onNetworkError?.(e);
        } finally {
            onFinally?.();
        }
    };

    return <ApiContext.Provider value={{ handleApiRequest, isRequestFinished }}>{children}</ApiContext.Provider>;
};
