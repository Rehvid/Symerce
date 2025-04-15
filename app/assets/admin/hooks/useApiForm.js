import { useState } from 'react';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { useApi } from '@/admin/hooks/useApi';
import { NOTIFICATION_TYPES } from '@/admin/constants/notificationConstants';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import { useNavigate } from 'react-router-dom';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';

const useApiForm = ({setValue, params, baseUrl}) => {
  const [formData, setFormData] = useState({});
  const { handleApiRequest } = useApi();
  const { addNotification } = useCreateNotification();
  const navigate = useNavigate();

  const fetchFormData = (endPoint, method, formFields = {}) => {
      const config = createApiConfig(endPoint, method);
      handleApiRequest(config, {
        onSuccess: ({ data }) => {
          const { formData } = data;
          if (formData) {
            setFormData(formData);

            Object.entries(formFields).forEach(([key, value]) => {
              setValue(key, value);
            });
          }
        },
      });
  }

  const defaultApiSuccessCallback = {
    onSuccess: ({ data, message }) => {
      addNotification(message, NOTIFICATION_TYPES.SUCCESS);
      if (!params.id && data.id) {
        navigate(`${baseUrl}/${data.id}/edit`, { replace: true });
      }
      navigate(baseUrl, { replace: true });
    },
  }

  const getApiConfig = () => params.id
    ? createApiConfig(`${baseUrl}/${params.id}`, HTTP_METHODS.PUT)
    : createApiConfig(baseUrl, HTTP_METHODS.POST)
  ;

  return { fetchFormData, defaultApiSuccessCallback, getApiConfig }
}

export default useApiForm;
