
const RestApiClient = () => {
    const BASE_URL = process.env.REACT_APP_API_URL;

    if (!BASE_URL) {
        throw new Error('BASE_URL is not defined in environment variables');
    }

    const executeRequest = async (apiConfig, requestData = {}) => {
        if (!apiConfig || !apiConfig.getConfig || typeof apiConfig.getConfig !== 'function') {
            throw new Error('Invalid apiConfig. Must be created using createApiConfig.');
        }

        try {
            const { data, meta, errors } = await sendRequest(apiConfig, requestData);

            return {
                data: data || {},
                meta: meta || null,
                errors: errors || null,
            };
        } catch (error) {
            console.error('Api request failed:', error);
            return {
                data: null,
                meta: null,
                errors: {
                    message: error.message,
                    code: error.code || 'unknown_error',
                    status: error.status || null,
                },
            };
        }
    };

    const sendRequest = async (apiConfig, data = {}) => {
        const { endpoint, method, queryParams, headers } = apiConfig.getConfig();
        const url = buildUrl(queryParams, endpoint, BASE_URL);

        const requestOptions = {
            method: method,
            headers: { ...getDefaultHeaders(), ...headers },
            body: method !== 'GET' && method !== 'HEAD' ? JSON.stringify(data) : null,
        };

        const response = await fetch(url, requestOptions);
        const responseData = await response.json();

        return {
            data: responseData.data,
            meta: responseData.meta,
            errors: responseData.errors,
        };
    };

    const getDefaultHeaders = () => {
        return {
            'Content-Type': 'application/json',
            credentials: 'include',
        };
    };

    const buildUrl = (queryParams, endpoint, baseUrl = '') => {
        let url = `${baseUrl !== '' ? baseUrl + '/' : ''}${endpoint}`;
        const query = new URLSearchParams(queryParams).toString();
        if (query) {
            url += `?${query}`;
        }
        return url;
    };

    return {
        buildUrl,
        executeRequest,
    };
};

export default RestApiClient;
