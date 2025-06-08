import { ApiResponse } from '@admin/common/interfaces/ApiResponse';
import { constructUrl } from '@admin/common/utils/helper';

type HttpMethod = 'GET' | 'POST' | 'PUT' | 'DELETE' | 'PATCH' | 'HEAD';


interface RequestOptions {
    headers?: Record<string, string>;
    queryParams?: Record<string, string | number | boolean>;
    body?: any;
    onUnauthorized?: () => void;
}

export const createApiClient = (baseUrl: string) => {
    if (!baseUrl) throw new Error('Base URL is required');

    const defaultHeaders = {
        'Content-Type': 'application/json',
        credentials: 'include',
    };

    const sendRequest = async <T>(
        method: HttpMethod,
        endpoint: string,
        options: RequestOptions = {}
    ): Promise<ApiResponse<T>> => {
        const { headers = {}, queryParams, body, onUnauthorized } = options;
        const url = constructUrl(baseUrl, endpoint, queryParams);
        const fetchOptions: RequestInit = {
            method,
            headers: { ...defaultHeaders, ...headers },
            body: method === 'GET' || method === 'HEAD' ? null : JSON.stringify(body),
        };

        try {
            const response = await fetch(url, fetchOptions);
            const responseData = await response.json();

            if (response.status === 401 && onUnauthorized) {
                onUnauthorized();
            }

            return {
                data: responseData.data ?? null,
                meta: responseData.meta,
                errors: responseData.errors,
                code: response.status,
                message: responseData.message ?? null,
            };
        } catch (error: any) {
            console.error('API request error:', error);
            return {
                data: null,
                errors: {
                    message: 'Błąd połączenia z serwerem',
                    code: error.code || 'unknown_error',
                    status: error.status || null,
                },
                code: 0,
                message: 'Network error',
            };
        }
    };

    return {
        get: <T>(endpoint: string, options?: Omit<RequestOptions, 'body'>) =>
            sendRequest<T>('GET', endpoint, {...options}),

        post: <T>(endpoint: string, body?: any, options?: Omit<RequestOptions, 'body'>) =>
            sendRequest<T>('POST', endpoint, { ...options, body }),

        put: <T>(endpoint: string, body?: any, options?: Omit<RequestOptions, 'body'>) =>
            sendRequest<T>('PUT', endpoint, { ...options, body }),

        patch: <T>(endpoint: string, body?: any, options?: Omit<RequestOptions, 'body'>) =>
            sendRequest<T>('PATCH', endpoint, { ...options, body }),

        delete: <T>(endpoint: string, options?: Omit<RequestOptions, 'body'>) =>
            sendRequest<T>('DELETE', endpoint, options),

    };
};
