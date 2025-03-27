export const createApiConfig = (endpoint, method, isAdmin) => {
    if (!endpoint) throw new Error('Endpoint is required');
    if (!method) throw new Error('Method is required!');

    let config = {
        endpoint: isAdmin ? `admin/${endpoint}` : `${endpoint}`,
        method,
        headers: {},
        queryParams: {}
    };

    return {
        setHeaders: (headers) => {
            config.headers = { ...config.headers, ...headers };
            return config;
        },
        addQueryParams: (params) => {
            config.queryParams = { ...config.queryParams, ...params };
            return config;
        },
        getConfig: () => config
    };
};
