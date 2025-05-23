import { createApiConfig } from '@/shared/api/ApiConfig';
import { useEffect, useState } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import { useApi } from '@/admin/hooks/useApi';
import restApiClient from '@/shared/api/RestApiClient';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';

const useListData = (endpoint, filters, setFilters, defaultSort) => {
    const { handleApiRequest } = useApi();
    const { addNotification } = useCreateNotification();
    const navigate = useNavigate();
    const location = useLocation();

    const [items, setItems] = useState([]);
    const [additionalData, setAdditionalData] = useState([]);
    const [pagination, setPagination] = useState({});
    const [isLoading, setIsLoading] = useState(true);
    const [sort, setSort] = useState(defaultSort);
    const queryParams = sort.orderBy === null ? { ...filters } : { ...filters, ...sort };

    useEffect(() => {
        if (sort.orderBy !== null) {
            fetchItemsWithQueryParams();
        } else {
            fetchItems();
        }
    }, []);

    useEffect(() => {
        if (!isLoading) {
            fetchItemsWithQueryParams();
        }
    }, [filters]);

    const fetchItemsWithQueryParams = () => {
        navigate(restApiClient().constructUrl(queryParams, location.pathname));
        fetchItems();
    };

    useEffect(() => {
        if (!isLoading) {
            fetchItemsWithQueryParams();
        }
    }, [sort]);

    const fetchItems = async () => {
        const config = createApiConfig(endpoint, HTTP_METHODS.GET).addQueryParams(queryParams);
        handleApiRequest(config, {
            onSuccess: ({ data, meta }) => {
                const additionalDataRequest = data.additionalData || [];
                const itemsRequest = Object.values(data).filter((item) => item !== additionalDataRequest);
                if (additionalDataRequest) {
                    setAdditionalData(additionalDataRequest);
                }
                setItems(itemsRequest);
                setPagination(meta);
                setIsLoading(false);
            },
            onError: (errors) => {
                addNotification(errors?.message || 'Wystąpił błąd, spróbuj ponownie', ALERT_TYPES.ERROR);
                setIsLoading(false);
            },
            onNetworkError: () => {
                addNotification('Wystąpił błąd, spróbuj ponownie', ALERT_TYPES.ERROR);
                setIsLoading(false);
            },
        });
    };

    const removeItem = async (deleteEndpoint) => {
        const config = createApiConfig(deleteEndpoint, HTTP_METHODS.DELETE);
        handleApiRequest(config, {
            onSuccess: ({ message }) => {
                addNotification(message, ALERT_TYPES.SUCCESS);

                const wasLastItemOnPage = items.length === 0;
                const isNotFirstPage = filters.page > 1;
                const shouldGoToPreviousPage = wasLastItemOnPage && isNotFirstPage;

                if (shouldGoToPreviousPage) {
                    setFilters((prevFilters) => ({
                        ...prevFilters,
                        page: prevFilters.page - 1,
                    }));
                } else {
                    fetchItems();
                }
            },
        });
    };

    return {
        items,
        pagination,
        isLoading,
        fetchItems,
        removeItem,
        sort,
        setSort,
        additionalData,
    };
};

export default useListData;
