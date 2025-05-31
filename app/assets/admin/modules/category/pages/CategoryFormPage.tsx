import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import { UserFormDataInterface } from '@admin/modules/user/interfaces/UserFormDataInterface';
import useApiFormSubmit from '@admin/shared/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/shared/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/shared/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import CategoryFormBody from '@admin/modules/category/components/CategoryFormBody';

const CategoryFormPage = () => {
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

  const baseApiUrl = 'admin/categories';
  const redirectSuccessUrl = '/admin/categories';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData, formData, formContext } = useFormInitializer<UserFormDataInterface>();

  useEffect(() => {
    const endpoint = isEditMode ? `admin/categories/${params.id}` : 'admin/categories/store-data';
    const formFieldNames = isEditMode
      ? ['name', 'isActive', 'description', 'parentCategoryId', 'slug', 'metaTitle', 'metaDescription']
      : [];

    getFormData(endpoint, setValue, formFieldNames);
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
      <FormApiLayout pageTitle={isEditMode ? 'Edytuj kategorie' : 'Dodaj kategorie'}>
        <CategoryFormBody
          register={register}
          fieldErrors={fieldErrors}
          control={control}
          formData={formData}
          formContext={formContext}
          params={params}
          watch={watch}
          setValue={setValue}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default CategoryFormPage;
