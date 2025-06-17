import { useNotification } from '@admin/common/context/NotificationContext';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { prepareDraggableDataToUpdateOrder } from '@admin/common/utils/helper';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';
import { DraggableItem } from '@admin/common/types/draggableItem';

const useDraggable = (endpoint: string) => {
    const { handleApiRequest } = useAdminApi();
    const { addNotification } = useNotification();

    const draggableCallback = async (item: DraggableItem) => {
        await handleApiRequest(HttpMethod.PUT, endpoint, {
            body: prepareDraggableDataToUpdateOrder(item),
            onSuccess: (data, meta, message) => {
                addNotification(message ?? '', NotificationType.SUCCESS);
            },
            onError: () => {
                addNotification(
                    'Nie udało się zaktualizować pozycji w tabeli. Proszę spróbować ponownie.',
                    NotificationType.ERROR,
                );
            },
            onNetworkError: () => {
                addNotification('Błąd sieci. Proszę spróbować ponownie.', NotificationType.ERROR);
            },
        });
    };

    return { draggableCallback };
};

export default useDraggable;
