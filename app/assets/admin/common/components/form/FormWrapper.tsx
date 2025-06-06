import Alert, { AlertProps } from '@admin/common/components/Alert';
import React, { useState, useEffect } from 'react';
import { FieldValues, SubmitHandler, UseFormSetError } from 'react-hook-form';
import { AlertType } from '@admin/common/enums/alertType';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { useValidationErrors } from '@admin/common/hooks/form/useValidationErrors';


type ApiConfig = {
  setBody: (body: any) => void;
};

interface FormWrapperProps<T extends FieldValues> {
    method: HttpMethod;
    endpoint: string;
    setError: UseFormSetError<T>;
    handleSubmit: (handler: SubmitHandler<T>) => (e?: React.BaseSyntheticEvent) => void;
    additionalClasses?: string;
    apiRequestCallbacks?: {
        onSuccess?: (data: any, meta?: any, message?: string) => void;
        onError?: (error: any) => void;
        onNetworkError?: () => void;
    };
    additionalAlerts?: AlertProps | null;
    modifySubmitValues?: ((values: T) => any) | null;
    children: React.ReactNode;
}

const FormWrapper = <T extends FieldValues>({
    method,
    endpoint,
    setError,
    handleSubmit,
    additionalClasses = '',
    apiRequestCallbacks = {},
    additionalAlerts = null,
    modifySubmitValues = null,
    children,
}: FormWrapperProps<T>) => {
    const { handleApiRequest } = useAdminApi();
    const { setValidationErrors } = useValidationErrors(setError);
    const [alert, setAlert] = useState<AlertProps | null>(additionalAlerts);

    const onSubmit: SubmitHandler<T> = async (values) => {
        setAlert(null);

        const finalBody = modifySubmitValues ? modifySubmitValues(values) : values;

        await handleApiRequest(method, endpoint, {
            body: finalBody,
            onSuccess: (data, meta, message) => {
                apiRequestCallbacks?.onSuccess?.(data, meta, message);
            },
            onError: (errors) => {
                apiRequestCallbacks?.onError?.(errors);

                setAlert({
                    variant: AlertType.ERROR,
                    message: errors?.message || 'Wystąpił błąd, spróbuj ponownie',
                });

                setValidationErrors(errors?.details || {});
            },
            onNetworkError: () => {
                apiRequestCallbacks?.onNetworkError?.();
                setAlert({
                    variant: AlertType.ERROR,
                    message: 'Wystąpił błąd sieci, spróbuj ponownie',
                });
            },
        });
    };

    useEffect(() => {
        if (additionalAlerts) {
            setAlert(additionalAlerts);
        }
    }, [additionalAlerts]);

    return (
        <>
            {alert && (
                <div className="my-6">
                    <Alert variant={alert.variant} message={alert.message} />
                </div>
            )}

            <form onSubmit={handleSubmit(onSubmit)} className={additionalClasses}>
                {children}
            </form>
        </>
    );
};

export default FormWrapper;
