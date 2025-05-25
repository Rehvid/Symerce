import { createApiConfig } from '@shared/api/ApiConfig';
import { HttpMethod } from '@admin/shared/enums/httpEnums';
import { useApi } from '@admin/hooks/useApi';
import { useCreateNotification } from '@admin/hooks/useCreateNotification';
import { ApiResponse } from '@admin/shared/types/ApiResponse';
import { AlertType } from '@admin/shared/enums/alertType';

export const useFetchItems = <T>() => {
  const { handleApiRequest } = useApi();
  const { addNotification } = useCreateNotification();

  const fetchItems = async (
    endpoint: string,
    queryParams: Record<string, any>,
    onSuccess: (items: T[], meta: any, additionalData: any) => void,
    onComplete?: () => void
  ) => {
    const config = createApiConfig(endpoint, HttpMethod.GET).addQueryParams(queryParams);

    handleApiRequest<ApiResponse<T>>(config, {
      onSuccess: ({ data, meta }) => {
        const { additionalData = null, ...rest } = data;
        const items = Object.values(rest).filter(item => item !== additionalData) as T[];
        onSuccess(items, meta, additionalData);
      },
      onError: (errors) => {
        addNotification(errors?.message || 'Wystąpił błąd, spróbuj ponownie', AlertType.ERROR);
      },
      onNetworkError: () => {
        addNotification('Wystąpił błąd sieci, spróbuj ponownie', AlertType.ERROR);
      },
      onFinally: onComplete
    })
  }

  return { fetchItems }
}
