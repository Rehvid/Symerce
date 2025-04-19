import { useState } from 'react';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { useApi } from '@/admin/hooks/useApi';
import { NOTIFICATION_TYPES } from '@/admin/constants/notificationConstants';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import { useNavigate } from 'react-router-dom';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';

const useApiForm = (setValue, params, baseApiUrl, redirectSuccessUrl = '') => {
    const [formData, setFormData] = useState({});
    const { handleApiRequest, isRequestFinished } = useApi();
    const [isFormReady, setIsFormReady] = useState(true);
    const { addNotification } = useCreateNotification();
    const navigate = useNavigate();

    const fetchFormData = (endPoint, method, formFieldNames = [], fieldModifiers = []) => {
        setIsFormReady(false);
        const config = createApiConfig(endPoint, method);
        handleApiRequest(config, {
            onSuccess: ({ data }) => {
                const { formData } = data;
                if (formData) {
                    setFormData(formData);

                    formFieldNames.forEach((fieldName) => {
                        if (formData[fieldName] !== undefined) {
                            let value = formData[fieldName];

                            if (fieldModifiers.length > 0) {
                                const modifier = fieldModifiers.find((mod) => mod.fieldName === fieldName);
                                if (modifier) {
                                    value = modifier.action(formData[fieldName]);
                                }
                            }

                            setValue(fieldName, value);
                        }
                    });
                    setIsFormReady(true);
                }
            },
        });
    };

    const defaultApiSuccessCallback = {
        onSuccess: ({ data, message }) => {
            addNotification(message, NOTIFICATION_TYPES.SUCCESS);
            if (!params.id && data.id) {
                navigate(`${redirectSuccessUrl}/${data.id}/edit`, { replace: true });
            }

            navigate(redirectSuccessUrl, { replace: true });
        },
    };

    const getApiConfig = () =>
        params.id
            ? createApiConfig(`${baseApiUrl}/${params.id}`, HTTP_METHODS.PUT)
            : createApiConfig(baseApiUrl, HTTP_METHODS.POST);

    return {
        fetchFormData,
        defaultApiSuccessCallback,
        getApiConfig,
        formData,
        setFormData,
        isRequestFinished,
        isFormReady,
    };
};

export default useApiForm;
