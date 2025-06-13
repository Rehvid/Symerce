import { createApiClient } from '@admin/common/api/ApiClient';
import React, { createContext, ReactNode, useContext, useState } from 'react';

import { HttpMethod } from '@admin/common/enums/httpEnums';
import { useUser } from '@admin/common/context/UserContext';

interface AdminApiProviderProps {
    baseUrl: string;
    children: ReactNode;
}

interface HandleApiRequestOptions {
    headers?: Record<string, string>;
    queryParams?: Record<string, string | number | boolean>;
    body?: any;
    onSuccess?: (data: any, meta?: any, message?: string | null) => void;
    onError?: (errors: any) => void;
    onNetworkError?: (error: unknown) => void;
    onFinally?: () => void;
}

interface AdminApiContextValue {
    isRequestFinished: boolean;
    handleApiRequest: (method: HttpMethod, endpoint: string, options?: HandleApiRequestOptions) => Promise<void>;
}

const AdminApiContext = createContext<AdminApiContextValue | undefined>(undefined);

export const AdminApiProvider: React.FC<AdminApiProviderProps> = ({ baseUrl, children }) => {
    const { setIsAuthenticated, setUser } = useUser();
    const [isRequestFinished, setIsRequestFinished] = useState<boolean>(true);
    const apiClient = createApiClient(baseUrl);

    const handleApiRequest = async (method: HttpMethod, endpoint: string, options: HandleApiRequestOptions = {}) => {
        setIsRequestFinished(false);
        const { headers, queryParams, body, onSuccess, onError, onNetworkError, onFinally } = options;

        try {
            let response = null;
            if (['get', 'delete'].includes(method.toLowerCase())) {
                response = await apiClient[method.toLowerCase() as 'get' | 'delete'](endpoint, {
                    headers,
                    queryParams,
                    onUnauthorized: () => {
                        setIsAuthenticated(false);
                        setUser({});
                    },
                });
            } else {
                response = await apiClient[method.toLowerCase() as 'post' | 'put' | 'patch'](endpoint, body, {
                    headers,
                    queryParams,
                    onUnauthorized: () => {
                        setIsAuthenticated(false);
                        setUser({});
                    },
                });
            }

            if (response.errors && Object.values(response.errors).length > 0) {
                onError?.(response.errors);
            } else {
                onSuccess?.(response.data, response.meta, response.message);
            }
        } catch (error) {
            console.error('Network error:', error);
            onNetworkError?.(error);
        } finally {
            setIsRequestFinished(true);
            onFinally?.();
        }
    };

    return (
        <AdminApiContext.Provider value={{ isRequestFinished, handleApiRequest }}>{children}</AdminApiContext.Provider>
    );
};

export const useAdminApi = (): AdminApiContextValue => {
    const context = useContext(AdminApiContext);
    if (!context) {
        throw new Error('useAdminApi must be used within an AdminApiProvider');
    }
    return context;
};
