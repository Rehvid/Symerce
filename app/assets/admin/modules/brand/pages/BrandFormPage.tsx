import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import BrandFormBody from '@admin/modules/brand/components/BrandFormBody';
import { BrandFormDataInterface } from '@admin/modules/brand/interfaces/BrandFormDataInterface';

const BrandFormPage = () => {
  const params = useParams();
  const isEditMode = params.id ?? false;
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    formState: { errors: fieldErrors },
  } = useForm<BrandFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/brands';
  const redirectSuccessUrl = '/admin/brands';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData, formData } = useFormInitializer<BrandFormDataInterface>();

  useEffect(() => {
    if (isEditMode) {
      const endpoint = `admin/brands/${params.id}`;
      const formFieldNames  = ['name', 'isActive'];

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
      <FormApiLayout pageTitle={isEditMode ? 'Edytuj marke' : 'Dodaj marke'}>
        <BrandFormBody
          register={register}
          fieldErrors={fieldErrors}
          formData={formData}
          setValue={setValue}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default BrandFormPage;
