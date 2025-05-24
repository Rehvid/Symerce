import Alert from '@admin/components/Alert';
import React, { useState, useEffect } from 'react';
import { useValidationErrors } from '@admin/hooks/useValidationErrors';
import { useApi } from '@admin/hooks/useApi';
import { FieldValues, SubmitHandler, UseFormSetError } from 'react-hook-form';
import { AlertType } from '@admin/shared/enums/alertType';

type Alert = {
  variant: string;
  message: string;
}

type ApiConfig = {
  setBody: (body: any) => void;
};

interface FormWrapperProps<T extends FieldValues> {
  apiConfig: ApiConfig,
  setError: UseFormSetError<T>;
  handleSubmit: (handler: SubmitHandler<T>) => (e?: React.BaseSyntheticEvent) => void;
  additionalClasses?: string,
  apiRequestCallbacks?: {
    onSuccess?: (data: any, meta?: any, message?: string) => void;
    onError?: (error: any) => void;
    onNetworkError?: () => void;
  };
  additionalAlerts?: AlertType;
  modifySubmitValues?: ((values: T) => any) | null;
  children: React.ReactNode
}

const FormWrapper: React.FC<FormWrapperProps> = ({
    apiConfig,
    setError,
    handleSubmit,
    additionalClasses = '',
    apiRequestCallbacks = {},
    additionalAlerts = {},
    modifySubmitValues = null,
    children
}) => {
  const { handleApiRequest } = useApi();
  const { setValidationErrors } = useValidationErrors(setError);
  const [alert, setAlert] = useState<Alert | null>(additionalAlerts);

  const onSubmit: SubmitHandler<T> = async (values) => {
    setAlert(null);

    const finalBody = modifySubmitValues ? modifySubmitValues(values) : values;
    apiConfig.setBody(finalBody);

    handleApiRequest(apiConfig, {
      onSuccess: (data, meta, message) => {
        apiRequestCallbacks?.onSuccess(data, meta, message);
      },
      onError: (errors) => {
        apiRequestCallbacks?.onError?.(errors);

        setAlert({
          variant: AlertType.ERROR,
          message: errors.message || 'Wystąpił błąd, spróbuj ponownie',
        });
        setValidationErrors(errors.details || {});
      },
      onNetworkError: () => {
        apiRequestCallbacks?.onNetworkError?.();

        setAlert({
          variant: AlertType.ERROR,
          message: 'Wystąpił błąd, spróbuj ponownie',
        });
      },
    });
  }

  useEffect(() => {
    if (additionalAlerts && Object.values(additionalAlerts).length > 0) {
      setAlert((prev) => ({
        ...prev,
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
  )
}

export default FormWrapper;
