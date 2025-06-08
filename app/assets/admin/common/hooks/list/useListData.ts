import { useFetchItems } from '@admin/common/hooks/list/useFetchItems';
import { useRemoveItem } from '@admin/common/hooks/list/useRemoveItem';
import React, { useMemo, useState, useEffect } from 'react';
import { useQueryParamsSync } from '@admin/common/hooks/list/useQueryParamsSync';
import { Pagination } from '@admin/common/interfaces/Pagination';
import { Sort } from '@admin/common/interfaces/Sort';
import { TableFilters } from '@admin/common/interfaces/TableFilters';

interface UseListDataProps<F extends TableFilters> {
  endpoint: string,
  filters: F,
  setFilters: React.Dispatch<React.SetStateAction<F>>,
  defaultSort: Sort
}

export const useListData = <T, F extends TableFilters>({
  endpoint,
  filters,
  setFilters,
  defaultSort,
}: UseListDataProps <F>) => {
  const { fetchItems } = useFetchItems<T>();
  const { removeItem } = useRemoveItem();
  const [items, setItems] = useState<T[]>([]);
  const [additionalData, setAdditionalData] = useState<any>(null);
  const [pagination, setPagination] = useState<Pagination | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [sort, setSort] = useState<Sort>(defaultSort);

  const queryParams = useMemo(() => (
    sort.orderBy === null ? filters : { ...filters, ...sort }
  ), [filters, sort]);

  useQueryParamsSync(queryParams);

  const loadItems =  () => {
    setIsLoading(true);
    fetchItems(endpoint, queryParams, (items, meta, additional) => {
      setItems(items);
      setPagination(meta);
      setAdditionalData(additional);
    }, () => setIsLoading(false));
  }

  useEffect(() => { loadItems(); }, []);
  useEffect(() => { if (!isLoading) loadItems(); }, [filters]);
  useEffect(() => { if (!isLoading) loadItems(); }, [sort]);

  const handleRemoveItem = (deleteEndpoint: string) => {
    const itemCount = Math.max(0, items.length - 1);
    return removeItem(deleteEndpoint, filters.page, itemCount, setFilters, loadItems);
  }

  return {
    items,
    pagination,
    isLoading,
    fetchItems: loadItems,
    removeItem: handleRemoveItem,
    sort,
    setSort,
    additionalData,
  };
}
