import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import PaymentMethodFormComponent from '@/admin/features/payment-method/components/PaymentMethodFormComponent';
import { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';

const PaymentMethodForm = () => {
  const params = useParams();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    formState: { errors: fieldErrors },
  } = useForm({
    mode: 'onBlur',
  });

  const { fetchFormData, defaultApiSuccessCallback, getApiConfig, formData, setFormData, isFormReady } = useApiForm(
    setValue,
    params,
    'admin/payment-methods',
    '/admin/payment-methods',
  );

  useEffect(() => {
    const endPoint = `admin/payment-methods/${params.id}`;
    fetchFormData(endPoint, HTTP_METHODS.GET, ['name', 'isActive', 'code', 'fee', 'isRequireWebhook']);
  }, []);

  if (!isFormReady) {
    return <FormSkeleton rowsCount={8} />;
  }

  return (
    <ApiForm
      apiConfig={getApiConfig()}
      handleSubmit={handleSubmit}
      setError={setError}
      apiRequestCallbacks={defaultApiSuccessCallback}
    >
      <FormLayout
        pageTitle={params.id ? 'Edytuj Płatność' : 'Dodaj płatność'}
        mainColumn={
         <PaymentMethodFormComponent
           fieldErrors={fieldErrors}
           register={register}
           setValue={setValue}
           formData={formData}
           setFormData={setFormData}
         />
        }
      />
    </ApiForm>
  );
}

export default PaymentMethodForm;
