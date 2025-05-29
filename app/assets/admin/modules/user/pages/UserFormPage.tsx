import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import { UserFormDataInterface } from '@admin/modules/user/interfaces/UserFormDataInterface';
import useApiFormSubmit from '@admin/shared/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/shared/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/shared/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import UserFormBody from '@admin/modules/user/components/UserFormBody';

const UserFormPage = () => {
  const params = useParams();
  const isEditMode = params.id ?? false;
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    formState: { errors: fieldErrors },
  } = useForm<UserFormDataInterface>({
    mode: 'onBlur',
    defaultValues: {
      id: isEditMode ? Number(params.id) : null
    }
  });

  const baseApiUrl = 'admin/users';
  const redirectSuccessUrl = '/admin/users';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData, formData, formContext } = useFormInitializer<UserFormDataInterface>();


  useEffect(() => {
    const endpoint = isEditMode ? `admin/users/${params.id}` : 'admin/users/store-data';
    const formFieldNames  = isEditMode
      ? ['firstname', 'surname', 'email', 'roles', 'isActive']
      : []

    getFormData(endpoint, setValue, formFieldNames);
  }, []);

  if (!isFormInitialize) {
    return <FormSkeleton rowsCount={12} />;
  }

  const modifySubmitValues = (values) => {
    const data = {...values};

    if (data.roles) {
      data.roles = values.roles.map(role => role.value);
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
      <FormApiLayout pageTitle={params.id ? 'Edytuj użytkownika' : 'Dodaj użytkownika'}>
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

export default UserFormPage;
