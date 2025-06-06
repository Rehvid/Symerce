export interface ApiResponse<T> {
    data: T | null;
    meta?: [] | null;
    errors?: [] | null;
    code: number;
    message?: string | null;
}
