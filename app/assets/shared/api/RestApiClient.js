import { HTTP_METHODS, HTTP_STATUS_CODES } from '@/admin/constants/httpConstants';

const RestApiClient = () => {
    const BASE_URL = process.env.REACT_APP_API_URL;

    if (!BASE_URL) {
        throw new Error('BASE_URL is not defined in environment variables');
    }

    const sendApiRequest = async (apiConfig, { onUnauthorized }) => {
        if (!apiConfig || !apiConfig.getConfig || typeof apiConfig.getConfig !== 'function') {
            throw new Error('Invalid apiConfig. Must be created using createApiConfig.');
        }

        const { endpoint, method, queryParams, headers, body } = apiConfig.getConfig();
        const url = constructUrl(queryParams, endpoint, BASE_URL);
        const requestOptions = {
            method,
            headers: { ...defaultHeaders, ...headers },
            body: method !== HTTP_METHODS.GET && method !== HTTP_METHODS.HEAD ? JSON.stringify(body) : null,
        };

        try {
            const response = await fetch(url, requestOptions);
            const responseData = await response.json();

            if (response.status === HTTP_STATUS_CODES.UNAUTHORIZED && onUnauthorized) {
                onUnauthorized();
            }

            return {
                data: responseData.data || {},
                meta: responseData.meta || {},
                errors: responseData.errors || {},
                code: response.status,
                message: responseData.message || null,
            };
        } catch (error) {
            console.error('Api request failed:', error);
            return {
                errors: {
                    message: 'Błąd połączenia z serwerem',
                    code: error.code || 'unknown_error',
                    status: error.status || null,
                },
            };
        }
    };

    const defaultHeaders = {
        'Content-Type': 'application/json',
        credentials: 'include',
    };

    const constructUrl = (queryParams, endpoint, baseUrl = '') => {
        let url = `${baseUrl !== '' ? baseUrl + '/' : ''}${endpoint}`;
        const query = new URLSearchParams(queryParams).toString();
        if (query) {
            url += `?${query}`;
        }
        return url;
    };

    return {
        constructUrl,
        sendApiRequest,
    };
};

export default RestApiClient;
