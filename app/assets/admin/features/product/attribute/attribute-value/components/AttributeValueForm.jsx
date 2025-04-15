import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import React, { useEffect } from 'react';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';

const AttributeValueForm = ({params}) => {
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    formState: { errors: fieldErrors },
  } = useForm({
    mode: 'onBlur',
    defaultValues: {
      attributeId: Number(params.attributeId) || null
    }
  });

  const { fetchFormData, defaultApiSuccessCallback, getApiConfig } = useApiForm(
    setValue,
    params,
    `admin/attributes/${params.attributeId}/values`,
    `/admin/products/attributes/${params.attributeId}/values`
  );

  if (params.id) {
    useEffect(() => {
      fetchFormData(`admin/attributes/${params.attributeId}/values/${params.id}/form-data`, HTTP_METHODS.GET, ['value']);
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
            {...register('value', {
              ...validationRules.required(),
              ...validationRules.minLength(3),
            })}
            type="text"
            id="value"
            label="Wartość"
            hasError={!!fieldErrors?.value}
            errorMessage={fieldErrors?.value?.message}
            isRequired
          />
        }
      />
    </ApiForm>
  )
}

export default AttributeValueForm;
