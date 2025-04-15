import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import useApiForm from '@/admin/hooks/useApiForm';
import { useForm } from 'react-hook-form';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { validationRules } from '@/admin/utils/validationRules';
import Input from '@/admin/components/form/controls/Input';
import React, { useEffect } from 'react';

const AttributeForm = ({params}) => {
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
    'admin/attributes',
    '/admin/products/attributes'
  );

  if (params.id) {
    useEffect(() => {
      fetchFormData(`admin/attributes/${params.id}/form-data`, HTTP_METHODS.GET, ['name']);
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

export default AttributeForm;
