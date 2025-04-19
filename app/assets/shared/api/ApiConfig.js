import { isValidEnumValue } from '@/admin/utils/helper';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';

export const createApiConfig = (endpoint, method) => {
    if (!endpoint) {
        throw new Error('Endpoint is required');
    }
    if (!isValidEnumValue(HTTP_METHODS, method)) {
        throw new Error(`Invalid HTTP method: ${method}`);
    }

    const config = {
        endpoint: `${endpoint}`,
        method,
        headers: {},
        queryParams: {},
        body: null,
    };

    const api = {
        setHeaders: (headers) => {
            config.headers = { ...config.headers, ...headers };
            return api;
        },
        addQueryParams: (params) => {
            config.queryParams = { ...config.queryParams, ...params };
            return api;
        },
        setBody: (body) => {
            config.body = body;
            return api;
        },
        getConfig: () => config,
    };

    return api;
};
