import React from 'react';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { createApiConfig } from '@shared/api/ApiConfig';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';
import { useNavigate } from 'react-router-dom';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import { useNotification } from '@admin/common/context/NotificationContext';

interface PropsUseFormSubmit {
  baseApiUrl: string,
  redirectSuccessUrl: string;
  params: {id?: string|number }
}

const useApiFormSubmit: React.FC<PropsUseFormSubmit> = (
  baseApiUrl,
  redirectSuccessUrl,
  params,
) => {
  const navigate = useNavigate();
  const { addNotification } = useNotification();

  const defaultApiSuccessCallback = {
    onSuccess: ({ data, message }) => {
      addNotification(message, NotificationType.SUCCESS);

      if (!params.id && data.id) {
        navigate(`${redirectSuccessUrl}/${data.id}/edit`, { replace: true });
      }

      navigate(redirectSuccessUrl, { replace: true });
    },
  };


  const getApiConfig = () => {
    return params.id
      ? createApiConfig(`${baseApiUrl}/${params.id}`, HttpMethod.PUT)
      : createApiConfig(baseApiUrl, HttpMethod.POST);
  }

  return { getApiConfig, defaultApiSuccessCallback };
}

export default useApiFormSubmit;
