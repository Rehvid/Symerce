import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import { CurrencyFormDataInterface } from '@admin/modules/currency/interfaces/CurrencyFormDataInterface';
import CurrencyFormBody from '@admin/modules/currency/components/CurrencyFormBody';

const CurrencyFormPage = () => {
  const params = useParams();
  const isEditMode = params.id ?? false;
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    formState: { errors: fieldErrors },
  } = useForm<CurrencyFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/currencies';
  const redirectSuccessUrl = '/admin/currencies';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData, formData, formContext } = useFormInitializer<CurrencyFormDataInterface>();


  useEffect(() => {
    if (params.id) {
      const endpoint = `admin/currencies/${params.id}`;
      const formFieldNames = ['code', 'name', 'symbol', 'roundingPrecision']

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
      <FormApiLayout pageTitle={params.id ? 'Edytuj walute' : 'Dodaj walute'}>
        <CurrencyFormBody
          register={register}
          fieldErrors={fieldErrors}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default CurrencyFormPage;
