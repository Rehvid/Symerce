import { useFetchItems } from '@admin/shared/hooks/list/useFetchItems';
import { useRemoveItem } from '@admin/shared/hooks/list/useRemoveItem';
import React, { useMemo, useState, useEffect } from 'react';
import { useQueryParamsSync } from '@admin/shared/hooks/list/useQueryParamsSync';
import { PaginationMetaInterface } from '@admin/shared/interfaces/PaginationMetaInterface';



type Filters = { page: number; [key: string]: any };
type Sort = { orderBy: string | null; [key: string]: any };


interface UseListDataProps {
  endpoint: string,
  filters: Filters,
  setFilters: React.Dispatch<React.SetStateAction<Filters>>,
  defaultSort: Sort
}

export const useListData = <T,>({
  endpoint,
  filters,
  setFilters,
  defaultSort,
}: UseListDataProps) => {
  const { fetchItems } = useFetchItems<T>();
  const { removeItem } = useRemoveItem();
  const [items, setItems] = useState<T[]>([]);
  const [additionalData, setAdditionalData] = useState<any>(null);
  const [pagination, setPagination] = useState<PaginationMetaInterface | null>(null);
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
