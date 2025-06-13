export interface TableFilters {
    limit: number;
    page: number;
    search?: string | null;
    [key: string]: any;
}
