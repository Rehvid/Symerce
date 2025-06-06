import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import { CountryFormDataInterface } from '@admin/modules/country/interfaces/CountryFormDataInterface';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import CountryFormBody from '@admin/modules/country/components/CountryFormBody';

const CountryFormPage = () => {
  const params = useParams();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    formState: { errors: fieldErrors },
  } = useForm<CountryFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/countries';
  const redirectSuccessUrl = '/admin/countries';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData } = useFormInitializer<CountryFormDataInterface>();

  useEffect(() => {
    if (params.id) {
      const endpoint = `admin/countries/${params.id}`;
      const formFieldNames = ['id', 'name', 'code', 'isActive']

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
      <FormApiLayout pageTitle={params.id ? 'Edytuj kraj' : 'Dodaj kraj'}>
        <CountryFormBody register={register} fieldErrors={fieldErrors} />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default CountryFormPage;
