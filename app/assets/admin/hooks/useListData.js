import { createApiConfig } from '@/shared/api/ApiConfig';
import { useEffect, useState } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import { useApi } from '@/admin/hooks/useApi';
import restApiClient from '@/shared/api/RestApiClient';

import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';

const useListData = (endpoint, filters) => {
    const { handleApiRequest } = useApi();
    const { addNotification } = useCreateNotification();
    const navigate = useNavigate();
    const location = useLocation();

    const [items, setItems] = useState([]);
    const [pagination, setPagination] = useState({});
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        fetchItems();
    }, []);

    useEffect(() => {
        if (!isLoading) {
            navigate(restApiClient().constructUrl(filters, location.pathname));
            fetchItems();
        }
    }, [filters]);

    const fetchItems = async () => {
        const config = createApiConfig(endpoint, HTTP_METHODS.GET).addQueryParams(filters);
        handleApiRequest(config, {
            onSuccess: ({ data, meta }) => {
                setItems(data);
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

    return { items, pagination, fetchItems, isLoading };
};

export default useListData;
