import React, { useEffect, useState } from 'react';
import Alert from '@/admin/components/Alert';
import { useApi } from '@/admin/hooks/useApi';
import { useValidationErrors } from '@/admin/hooks/useValidationErrors';
import { ALERT_TYPES } from '@/admin/constants/alertConstants';

const AppForm = ({
    apiConfig,
    additionalClasses,
    handleSubmit,
    setError,
    apiRequestCallbacks = {},
    additionalAlerts = {},
    children,
}) => {
    const { handleApiRequest } = useApi();
    const { setValidationErrors } = useValidationErrors(setError);
    const [alert, setAlert] = useState(additionalAlerts);

    const onSubmit = async (values) => {
        setAlert({});
        apiConfig.setBody(values);

        handleApiRequest(apiConfig, {
            onSuccess: (data, meta, message) => {
                apiRequestCallbacks?.onSuccess(data, meta, message);
            },
            onError: (errors) => {
                apiRequestCallbacks?.onError?.(errors);

                setAlert({
                    variant: ALERT_TYPES.ERROR,
                    message: errors.message || 'Wystąpił błąd, spróbuj ponownie',
                });
                setValidationErrors(errors.details || {});
            },
            onNetworkError: () => {
                apiRequestCallbacks?.onNetworkError?.();

                setAlert({
                    variant: ALERT_TYPES.ERROR,
                    message: 'Wystąpił błąd, spróbuj ponownie',
                });
            },
        });
    };

    useEffect(() => {
        if (additionalAlerts && Object.values(additionalAlerts).length > 0) {
            setAlert((alert) => ({
                ...alert,
                ...additionalAlerts,
            }));
        }
    }, [additionalAlerts]);

    return (
        <>
            {alert && Object.keys(alert).length > 0 && (
                <div className="my-6 ">
                    <Alert variant={alert.variant} message={alert.message} />
                </div>
            )}

            <form onSubmit={handleSubmit(onSubmit)} className={additionalClasses}>
                {children}
            </form>
        </>
    );
};

export default AppForm;
