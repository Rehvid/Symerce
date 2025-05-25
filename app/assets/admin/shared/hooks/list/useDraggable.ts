import React from 'react';
import { useApi } from '@admin/hooks/useApi';
import { useCreateNotification } from '@admin/hooks/useCreateNotification';
import { createApiConfig } from '@shared/api/ApiConfig';
import { HttpMethod } from '@admin/shared/enums/httpEnums';
import { prepareDraggableDataToUpdateOrder } from '@admin/utils/helper';
import { AlertType } from '@admin/shared/enums/alertType';

interface UseDraggableProps {
  endpoint: string,
}

type DraggableItem = {
  movedId: number,
  newPosition: number,
  oldPosition: number,
}

const useDraggable: React.FC<UseDraggableProps> = (endpoint) => {
  const { handleApiRequest } = useApi();
  const { addNotification } = useCreateNotification();

  const apiConfig = createApiConfig(endpoint, HttpMethod.PUT);

  const draggableCallback = (items: DraggableItem) => {
    apiConfig.setBody(prepareDraggableDataToUpdateOrder(items));
    handleApiRequest(apiConfig, {
      onSuccess: ({ message }) => {
        addNotification(message, AlertType.SUCCESS);
      },
      onError: () => {
        addNotification(
          'Nie udało się zaktualizować pozycji w tabeli. Proszę spróbować ponownie.',
          AlertType.ERROR
        );
      },
    });
  }

  return { draggableCallback };
}

export default useDraggable;
