import { createApiConfig } from '@shared/api/ApiConfig';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { useNotification } from '@admin/common/context/NotificationContext';
import { ApiResponse } from '@admin/common/types/apiResponse';
import { AlertType } from '@admin/common/enums/alertType';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';

export const useFetchItems = <T>() => {
    const { handleApiRequest } = useAdminApi();
    const { addNotification } = useNotification();

    const fetchItems = async (
        endpoint: string,
        queryParams: Record<string, any>,
        onSuccess: (items: T[], meta: any, additionalData: any) => void,
        onComplete?: () => void,
    ) => {
        await handleApiRequest(HttpMethod.GET, endpoint, {
            queryParams,
            onSuccess: (data, meta) => {
                const { additionalData = null, ...rest } = data ?? {};
                const items = Object.values(rest).filter((item) => item !== additionalData) as T[];
                onSuccess(items, meta, additionalData);
            },
            onError: (errors) => {
                addNotification(errors?.message || 'Wystąpił błąd, spróbuj ponownie', NotificationType.ERROR);
            },
            onNetworkError: () => {
                addNotification('Wystąpił błąd sieci, spróbuj ponownie', NotificationType.ERROR);
            },
            onFinally: onComplete,
        });
    };

    return { fetchItems };
};
