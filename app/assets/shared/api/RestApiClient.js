import { ApiConfig } from './ApiConfig';

const RestApiClient = () => {
    const BASE_URL = process.env.REACT_APP_API_URL;

    const createConfig = (endpoint, method, headers = {}, queryParams = {}) => {
        return new ApiConfig(endpoint, method, headers, queryParams);
    };

    const sendRequest = async (config, data = {}) => {
        if (!(config instanceof ApiConfig)) {
            throw new Error('Invalid config. Use createConfig to generate a valid configuration.');
        }

        const { endpoint, method, queryParams, headers } = config;
        const url = buildUrl(queryParams, endpoint, BASE_URL);

        const requestOptions = {
            method: method,
            headers: { ...getDefaultHeaders(), ...headers },
            body: method !== 'GET' && method !== 'HEAD' ? JSON.stringify(data) : null,
        };

        return (await fetch(url, requestOptions)).json();
    };

    const buildUrl = (queryParams, endpoint, baseUrl = '') => {
        let url = `${baseUrl !== '' ? baseUrl + '/' : ''}${endpoint}`;
        const query = new URLSearchParams(queryParams).toString();
        if (query) {
            url += `?${query}`;
        }
        return url;
    };

    const getDefaultHeaders = () => {
        return {
            'Content-Type': 'application/json',
        };
    };

    return {
        createConfig,
        sendRequest,
        buildUrl,
    };
};

export default RestApiClient;
