import { useForm } from 'react-hook-form';
import { UserFormData } from '@admin/modules/user/interfaces/UserFormData';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import UserFormBody from '@admin/modules/user/components/UserFormBody';

const UserForm = () => {
    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/users',
        redirectSuccessUrl: '/admin/users',
    });
    const requestConfig = getRequestConfig();

  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    formState: { errors: fieldErrors },
  } = useForm<UserFormData>({
    mode: 'onBlur',
    defaultValues: {
      id: entityId
    }
  });

  const { isFormInitialize, getFormData, formData, formContext } = useFormInitializer<UserFormData>();


  useEffect(() => {
    const endpoint = isEditMode ? `admin/users/${entityId}` : 'admin/users/store-data';
    const formFieldNames  = isEditMode
      ? ['firstname', 'surname', 'email', 'roles', 'isActive'] satisfies (keyof UserFormData)[]
      : []

    getFormData(endpoint, setValue, formFieldNames);
  }, []);

  if (!isFormInitialize) {
    return <FormSkeleton rowsCount={12} />;
  }

  return (
    <FormWrapper
        method={requestConfig.method}
        endpoint={requestConfig.endpoint}
      handleSubmit={handleSubmit}
      setError={setError}
      apiRequestCallbacks={defaultApiSuccessCallback}
    >
      <FormApiLayout pageTitle={isEditMode ? 'Edytuj użytkownika' : 'Dodaj użytkownika'}>
        <UserFormBody
          register={register}
          fieldErrors={fieldErrors}
          control={control}
          formData={formData}
          setValue={setValue}
          isEditMode={isEditMode}
          formContext={formContext}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default UserForm;
