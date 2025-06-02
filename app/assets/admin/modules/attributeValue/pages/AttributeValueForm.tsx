import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/shared/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/shared/hooks/form/useFormInitializer';
import { CustomerFormDataInterface } from '@admin/modules/customer/interfaces/CustomerFormDataInterface';
import { useEffect } from 'react';
import FormSkeleton from '@admin/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/shared/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import AttributeValueFormBody from '@admin/modules/attributeValue/components/AttributeValueFormBody';

const AttributeValueForm = () => {
  const params = useParams();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    formState: { errors: fieldErrors },
  } = useForm<AttributeFormDataInterface>({
    mode: 'onBlur',
    defaultValues: {
      attributeId: Number(params.attributeId) || null,
    },
  });

  const baseApiUrl = `admin/attributes/${params.attributeId}/values`;
  const redirectSuccessUrl = `/admin/products/attributes/${params.attributeId}/values`;
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData } = useFormInitializer<CustomerFormDataInterface>();
  const isEditMode = params.id ?? false;

  useEffect(() => {
    if (params.id) {
      const endpoint = `admin/attributes/${params.attributeId}/values/${params.id}`;
      const formFieldNames = isEditMode ? ['value'] : [];

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
      <FormApiLayout pageTitle={params.id ? 'Edytuj wartość' : 'Dodaj wartość'}>
        <AttributeValueFormBody
          register={register}
          fieldErrors={fieldErrors}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default AttributeValueForm;
