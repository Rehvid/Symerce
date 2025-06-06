import React from 'react';
import { useNotification } from '@admin/common/context/NotificationContext';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { prepareDraggableDataToUpdateOrder } from '@admin/common/utils/helper';
import { AlertType } from '@admin/common/enums/alertType';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';

interface UseDraggableProps {
  endpoint: string,
}

type DraggableItem = {
  movedId: number,
  newPosition: number,
  oldPosition: number,
}

const useDraggable: React.FC<UseDraggableProps> = (endpoint) => {
  const { handleApiRequest } = useAdminApi();
  const { addNotification } = useNotification();

    const draggableCallback = async (item: DraggableItem) => {
        await handleApiRequest(HttpMethod.PUT, endpoint, {
            body: prepareDraggableDataToUpdateOrder(item),
            onSuccess: ({ message }) => {
                addNotification(message, NotificationType.SUCCESS);
            },
            onError: () => {
                addNotification(
                    'Nie udało się zaktualizować pozycji w tabeli. Proszę spróbować ponownie.',
                    AlertType.ERROR
                );
            },
            onNetworkError: () => {
                addNotification('Błąd sieci. Proszę spróbować ponownie.', AlertType.ERROR);
            },
        });
    };

  return { draggableCallback };
}

export default useDraggable;
