import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import { CustomerFormDataInterface } from '@admin/modules/customer/interfaces/CustomerFormDataInterface';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import CustomerFormBody from '@admin/modules/customer/components/CustomerFormBody';
import AttributeFormBody from '@admin/modules/attribute/components/AttributeFormBody';

const AttributeForm = () => {
  const params = useParams();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    watch,
    control,
    formState: { errors: fieldErrors },
  } = useForm<AttributeFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/attributes';
  const redirectSuccessUrl = '/admin/products/attributes';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData, formData, formContext } = useFormInitializer<CustomerFormDataInterface>();
  const isEditMode = params.id ?? false;

  useEffect(() => {
    const endpoint = isEditMode ? `admin/attributes/${params.id}` : `admin/attributes/store-data`;
    const formFieldNames = isEditMode ? ['type', 'name', 'isActive'] : [];

    getFormData(endpoint, setValue, formFieldNames);
  }, []);

  if (!isFormInitialize) {
    return <FormSkeleton rowsCount={12} />;
  }

  const modifySubmitValues = (values: CustomerFormDataInterface) => {
    const data = {...values};

    if (typeof data.type === 'object' && data.type !== null) {
      data.type = values.type?.value;
    }

    return data;
  }


  return (
    <FormWrapper
      apiConfig={getApiConfig()}
      handleSubmit={handleSubmit}
      setError={setError}
      apiRequestCallbacks={defaultApiSuccessCallback}
      modifySubmitValues={modifySubmitValues}
    >
      <FormApiLayout pageTitle={params.id ? 'Edytuj atrybut' : 'Dodaj atrytbut'}>
        <AttributeFormBody
          register={register}
          fieldErrors={fieldErrors}
          isEditMode={isEditMode}
          watch={watch}
          control={control}
          formData={formData}
          formContext={formContext}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default AttributeForm;
