import { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';
import { SORT_DIRECTION } from '@/admin/constants/sortDirectionConstants';

const useListDefaultQueryParams = () => {
    const currentParams = new URLSearchParams(location.search);

    const defaultFilters = {
        limit: Number(currentParams.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
        page: Number(currentParams.get('page')) || 1,
    };
    if (currentParams.has('search')) {
        defaultFilters.search = currentParams.get('search');
    }

    const defaultSort = {
        orderBy: currentParams.get('orderBy') || null,
        direction: currentParams.get('direction') || SORT_DIRECTION.ASC,
    };

    const getCurrentParam = (paramKey, expectedValueCallback) => {
        return currentParams.has(paramKey) ? expectedValueCallback(currentParams.get(paramKey)) : null
    }

    return { defaultFilters, defaultSort, getCurrentParam };
};

export default useListDefaultQueryParams;
