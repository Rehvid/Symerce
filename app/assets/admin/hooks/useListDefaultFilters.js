import { PAGINATION_FILTER_DEFAULT_OPTION } from '@/admin/components/table/Filters/PaginationFilter';

const useListDefaultFilters = () => {
  const currentFilters = new URLSearchParams(location.search);

  const defaultFilters = {
    limit: Number(currentFilters.get('limit')) || PAGINATION_FILTER_DEFAULT_OPTION,
    page: Number(currentFilters.get('page')) || 1,
  };
  if (currentFilters.has('search')) {
    defaultFilters.search = currentFilters.get('search');
  }

  return {
    defaultFilters
  }
}

export default useListDefaultFilters;
