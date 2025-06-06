import { PAGINATION_FILTER_DEFAULT_OPTION } from '@admin/common/components/table/partials/filters/PaginationFilter';
import { SortDirection } from '@admin/common/enums/sortDirection';
import { ListDefaultFiltersInterface } from '@admin/common/interfaces/ListDefaultFiltersInterface';
import { SortInterface } from '@admin/common/interfaces/SortInterface';


const useListDefaultQueryParams = () => {
  const params = new URLSearchParams(window.location.search);

  const defaultFilters: ListDefaultFiltersInterface = {
    limit: Number(params.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
    page: Number(params.get('page')) || 1,
  };

  if (params.has('search')) {
    defaultFilters.search = params.get('search');
  }

  const defaultSort: SortInterface = {
    orderBy: params.get('orderBy') || null,
    direction: (params.get('direction') as  SortInterface ['direction']) || SortDirection.ASC,
  };

  const getCurrentParam = <T>(key: string, transform: (value: string) => T): T | null =>
    params.has(key) ? transform(params.get(key) as string) : null;

  return { defaultFilters, defaultSort, getCurrentParam };
}

export default useListDefaultQueryParams;
