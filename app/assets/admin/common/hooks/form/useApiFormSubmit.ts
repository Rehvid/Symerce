import { HttpMethod } from '@admin/common/enums/httpEnums';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';
import { useNavigate, useParams } from 'react-router-dom';
import { useNotification } from '@admin/common/context/NotificationContext';
import { ApiResponse } from '@admin/common/interfaces/ApiResponse';
import { ApiResponseEntityWithId } from '@admin/common/interfaces/ApiResponseEntityWithId';

interface UseFormSubmitProps {
  baseApiUrl: string,
  redirectSuccessUrl: string;
}

interface RequestConfig {
    method: HttpMethod;
    endpoint: string;
}

const useApiFormSubmit = ({
    baseApiUrl,
    redirectSuccessUrl,
}: UseFormSubmitProps) => {
    const navigate = useNavigate();
    const { addNotification } = useNotification();
    const params = useParams();
    const entityId = params.id ? Number(params.id) : null;
    const isEditMode = !!entityId;

  const defaultApiSuccessCallback = {
    onSuccess: ({ data, message }: ApiResponse<ApiResponseEntityWithId>) => {
      if (message) {
          addNotification(message, NotificationType.SUCCESS);
      }
      if (data?.id) {
          navigate(`${redirectSuccessUrl}/${data.id}/edit`, { replace: true });
      }
    },
  };


    const getRequestConfig = (): RequestConfig => ({
        method: !!entityId ? HttpMethod.PUT : HttpMethod.POST,
        endpoint: !!entityId ? `${baseApiUrl}/${entityId}` : baseApiUrl,
    });

  return { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode };
}

export default useApiFormSubmit;
