import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import { PaymentMethodFormDataInterface } from '@admin/modules/paymentMethod/PaymentMethodFormDataInterface';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import PaymentMethodFormBody from '@admin/modules/paymentMethod/components/PaymentMethodFormBody';

const PaymentMethodFormPage = () => {
  const params = useParams();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    formState: { errors: fieldErrors },
  } = useForm<PaymentMethodFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/payment-methods';
  const redirectSuccessUrl = '/admin/payment-methods';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData, formData, setFormData } = useFormInitializer<PaymentMethodFormDataInterface>();

  useEffect(() => {
    if (params.id) {
      const endpoint = `admin/payment-methods/${params.id}`;
      const formFieldNames = ['name', 'isActive', 'code', 'fee', 'isRequireWebhook', 'config']

      getFormData(endpoint, setValue, formFieldNames);
    }
  }, []);

  if (!isFormInitialize) {
    return <FormSkeleton rowsCount={12} />;
  }

  return (
    <FormWrapper
      apiConfig={getApiConfig()}
      handleSubmit={handleSubmit}
      setError={setError}
      apiRequestCallbacks={defaultApiSuccessCallback}
    >
      <FormApiLayout pageTitle={params.id ? 'Edytuj metodę płatności' : 'Dodaj metodę płatności'}>
        <PaymentMethodFormBody
          register={register}
          fieldErrors={fieldErrors}
          control={control}
          formData={formData}
          setValue={setValue}
          setFormData={setFormData}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default PaymentMethodFormPage;
