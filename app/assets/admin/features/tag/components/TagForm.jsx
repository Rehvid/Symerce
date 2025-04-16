import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import React, { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';

const TagForm = ({params}) => {
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    formState: { errors: fieldErrors },
  } = useForm({
    mode: 'onBlur',
  });

  const { fetchFormData, defaultApiSuccessCallback, getApiConfig } = useApiForm(
    setValue,
    params,
    'admin/tags',
    '/admin/tags'
  );

  if (params.id) {
    useEffect(() => {
      fetchFormData(`admin/tags/${params.id}/form-data`, HTTP_METHODS.GET, ['name']);
    }, []);
  }

  return (
    <ApiForm
      apiConfig={getApiConfig()}
      handleSubmit={handleSubmit}
      setError={setError}
      apiRequestCallbacks={defaultApiSuccessCallback}
    >
      <FormLayout
        mainColumn={
          <Input
            {...register('name', {
              ...validationRules.required(),
              ...validationRules.minLength(3),
            })}
            type="text"
            id="name"
            label="Nazwa"
            hasError={!!fieldErrors?.name}
            errorMessage={fieldErrors?.name?.message}
            isRequired
          />
        }
      />
    </ApiForm>
  )
}

export default TagForm;
