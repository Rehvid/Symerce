export const createApiConfig = (endpoint, method, isAdmin) => {
    if (!endpoint) throw new Error('Endpoint is required');
    if (!method) throw new Error('Method is required!');

    let config = {
        endpoint: isAdmin ? `admin/${endpoint}` : `${endpoint}`,
        method,
        headers: {},
        queryParams: {}
    };

    const api =  {
        setHeaders: (headers) => {
            config.headers = { ...config.headers, ...headers };
            return api;
        },
        addQueryParams: (params) => {
            config.queryParams = { ...config.queryParams, ...params };
            return api;
        },
        getConfig: () => config
    };

    return api;
};
