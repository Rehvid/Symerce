import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { prepareDraggableDataToUpdateOrder } from '@/admin/utils/helper';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';
import { useApi } from '@/admin/hooks/useApi';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';

const useDraggable = (endpoint) => {
    const { handleApiRequest } = useApi();
    const { addNotification } = useCreateNotification();

    const apiConfig = createApiConfig(endpoint, HTTP_METHODS.PUT);

    const draggableCallback = (items) => {
        const draggableData = prepareDraggableDataToUpdateOrder(items);
        apiConfig.setBody(draggableData);
        handleApiRequest(apiConfig, {
            onSuccess: ({ message }) => {
                addNotification(message, ALERT_TYPES.SUCCESS);
            },
            onError: () => {
                addNotification(
                    'Nie udało się zaktualizować pozycji w tabeli. Proszę spróbować ponownie.',
                    ALERT_TYPES.ERROR,
                );
            },
        });
    };

    return { draggableCallback };
};

export default useDraggable;
