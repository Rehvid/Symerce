import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import React, { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import SettingFormMainColumn from '@/admin/features/setting/components/SettingFormMainColumn';

const SettingForm = ({params}) => {
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    formState: { errors: fieldErrors },
  } = useForm({
    mode: 'onBlur',
  });

  const {
    fetchFormData,
    defaultApiSuccessCallback,
    getApiConfig,
    formData,
    isRequestFinished
  } = useApiForm(
    setValue,
    params,
    'admin/settings',
    '/admin/settings'
  );

  useEffect(() => {
    const endpointFormData = params.id ?
      `admin/settings/${params.id}/form-data`
      : `admin/settings/form-data`

      fetchFormData(endpointFormData, HTTP_METHODS.GET, ['name', 'value', 'type', 'isProtected']);
  }, []);


  if (!isRequestFinished) {
    return <FormSkeleton rowsCount={3} />
  }

  const { isProtected } = formData;

  return (
    <ApiForm
      apiConfig={getApiConfig()}
      handleSubmit={handleSubmit}
      setError={setError}
      apiRequestCallbacks={defaultApiSuccessCallback}
    >
      <FormLayout
        mainColumn={
          <SettingFormMainColumn
            isProtected={isProtected}
            register={register}
            fieldErrors={fieldErrors}
            formData={formData}
            setValue={setValue}
          />
        }
      />
    </ApiForm>
  )

}

export default SettingForm;
