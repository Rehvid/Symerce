import {ApiConfig} from "./ApiConfig";

const RestApiClient = () => {
    const baseUrl = process.env.REACT_APP_API_URL;

    const createConfig = (endpoint, method, headers = {}, queryParams = {}) => {
        return new ApiConfig(endpoint, method, headers, queryParams);
    };

    const sendRequest = async (config, data = {}) => {
        if (!(config instanceof ApiConfig)) {
            throw new Error("Invalid config. Use createConfig to generate a valid configuration.");
        }

        const { endpoint, method, queryParams, headers } = config;
        const url = buildUrl(baseUrl, endpoint, queryParams);

        const requestOptions = {
            method: method,
            headers: {...getDefaultHeaders(), ...headers},
            body: method !== 'GET' && method !== 'HEAD' ? JSON.stringify(data) : null,
        };

        return  (await fetch(url, requestOptions)).json();
    }

    const buildUrl = (baseUrl, endpoint, queryParams) => {
        let url = `${baseUrl}/${endpoint}`;
        const query = new URLSearchParams(queryParams).toString();
        if (query) {
            url += `?${query}`;
        }
        return url;
    };

    const getDefaultHeaders = () => {
        return {
            'Content-Type': 'application/json'
        }
    }

    return {
        createConfig,
        sendRequest
    };
}

export default RestApiClient;
