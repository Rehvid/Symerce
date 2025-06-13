import { PAGINATION_FILTER_DEFAULT_OPTION } from '@admin/common/components/tableList/filters/PaginationFilter';
import { SortDirection } from '@admin/common/enums/sortDirection';
import { TableFilters } from '@admin/common/interfaces/TableFilters';
import { Sort } from '@admin/common/interfaces/Sort';

const useListDefaultQueryParams = () => {
    const params = new URLSearchParams(window.location.search);

    const defaultFilters: TableFilters = {
        limit: Number(params.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(params.get('page')) || 1,
    };

    const defaultSort: Sort = {
        orderBy: params.get('orderBy') || null,
        direction: (params.get('direction') as Sort['direction']) || SortDirection.ASC,
    };

    const getCurrentParam = <T>(key: string, transform: (value: string) => T): T | null =>
        params.has(key) ? transform(params.get(key) as string) : null;

    return { defaultFilters, defaultSort, getCurrentParam };
};

export default useListDefaultQueryParams;
