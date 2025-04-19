import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import React, { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import CarrierFormSideColumn from '@/admin/features/carrier/components/CarrierFormSideColumn';
import CarrierFormMainColumn from '@/admin/features/carrier/components/CarrierFormMainColumn';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';
import { useParams } from 'react-router-dom';

const CarrierForm = () => {
  const params = useParams();

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
    setFormData,
    isFormReady
  } = useApiForm(
    setValue,
    params,
    'admin/carriers',
    '/admin/carriers'
  );

  if (params.id) {
    useEffect(() => {
      fetchFormData(
        `admin/carriers/${params.id}/form-data`,
        HTTP_METHODS.GET,
        ['name', 'isActive', 'fee'],
        [{
          fieldName: 'fee',
          action: (item) => {
            return item.amount;
          }
        }]
      );

    }, []);
  }

  if (!isFormReady ) {
    return <FormSkeleton rowsCount={3} />
  }

  return (
    <ApiForm
      apiConfig={getApiConfig()}
      handleSubmit={handleSubmit}
      setError={setError}
      apiRequestCallbacks={defaultApiSuccessCallback}
    >
      <FormLayout
        pageTitle={params.id ? 'Edytuj Przewoźnika' : 'Dodaj Przewoźnika'}
        mainColumn={
          <CarrierFormMainColumn register={register} fieldErrors={fieldErrors} formData={formData} />
        }
        sideColumn={
          <CarrierFormSideColumn register={register} formData={formData} setValue={setValue} setFormData={setFormData}/>
        }
      />
    </ApiForm>
  )
}
export default CarrierForm;
