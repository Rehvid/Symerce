import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import { UserFormDataInterface } from '@admin/modules/user/interfaces/UserFormDataInterface';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import UserFormBody from '@admin/modules/user/components/UserFormBody';
import TagFormBody from '@admin/modules/tag/components/TagFormBody';

const TagFormPage = () => {
  const params = useParams();
  const isEditMode = params.id ?? false;
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    watch,
    formState: { errors: fieldErrors },
  } = useForm<UserFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/tags';
  const redirectSuccessUrl = '/admin/tags';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData } = useFormInitializer<UserFormDataInterface>();

  useEffect(() => {
    if (isEditMode) {
      const endpoint = `admin/tags/${params.id}`;
      const formFieldNames  = ['name', 'backgroundColor', 'textColor', 'isActive']

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
      <FormApiLayout pageTitle={isEditMode ? 'Edytuj tag' : 'Dodaj tag'}>
        <TagFormBody
          register={register}
          fieldErrors={fieldErrors}
          control={control}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default TagFormPage;
