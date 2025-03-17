export class ApiConfig {
    constructor(endpoint, method, headers = {}, queryParams = {}) {
        if (!endpoint) {
            throw new Error('Endpoint is required');
        }
        if (!method) {
            throw new Error('Method is required!');
        }

        this.endpoint = endpoint;
        this.method = method;
        this.headers = headers;
        this.queryParams = queryParams;
    }
}
