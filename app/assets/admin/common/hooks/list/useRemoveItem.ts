import { createApiConfig } from '@shared/api/ApiConfig';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { AlertType } from '@admin/common/enums/alertType';
import { useNotification } from '@admin/common/context/NotificationContext';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';


export const useRemoveItem = () => {
    const { handleApiRequest } = useAdminApi();
    const { addNotification } = useNotification();

    const removeItem = async (
        deleteEndpoint: string,
        currentPage: number,
        itemCount: number,
        setFilters: (updater: (prev: any) => any) => void,
        onReload: () => void
    ) => {
        await handleApiRequest(HttpMethod.DELETE, deleteEndpoint, {
            onSuccess: ( data, meta, message) => { //TODO: Resolve problem
                addNotification(message ?? '', NotificationType.SUCCESS);

                const shouldGoBack = itemCount === 0 && currentPage > 1;
                if (shouldGoBack) {
                    setFilters((prev) => ({ ...prev, page: prev.page - 1 }));
                } else {
                    onReload();
                }
            },
            onError: (errors) => {
                addNotification(errors?.message || 'Nie udało się usunąć elementu.', NotificationType.ERROR);
            },
            onNetworkError: () => {
                addNotification('Błąd sieci. Spróbuj ponownie.', NotificationType.ERROR);
            },
        });
    };

    return { removeItem };
};
