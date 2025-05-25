import { createApiConfig } from '@shared/api/ApiConfig';
import { HttpMethod } from '@admin/shared/enums/httpEnums';
import { AlertType } from '@admin/shared/enums/alertType';
import { useCreateNotification } from '@admin/hooks/useCreateNotification';
import { useApi } from '@admin/hooks/useApi';


export const useRemoveItem = () => {
  const { handleApiRequest } = useApi();
  const { addNotification } = useCreateNotification();

  const removeItem = async (
    deleteEndpoint: string,
    currentPage: number,
    itemCount: number,
    setFilters: (updater: (prev: any) => any) => void,
    onReload: () => void
  ) => {
    const config = createApiConfig(deleteEndpoint, HttpMethod.DELETE);
    handleApiRequest(config, {
      onSuccess: ({ message }) => {
        addNotification(message, AlertType.SUCCESS);

        const shouldGoBack = itemCount === 0 && currentPage > 1;
        if (shouldGoBack) {
          setFilters((prev) => ({ ...prev, page: prev.page - 1 }));
        } else {
          onReload();
        }
      },
    });
  };

  return { removeItem };
}
