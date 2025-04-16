import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import React, { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import CarrierFormMainColumn from '@/admin/features/carrier/components/CarrierFormMainColumn';
import CarrierFormSideColumn from '@/admin/features/carrier/components/CarrierFormSideColumn';
import CurrencyFormMainColumn from '@/admin/features/currency/components/CurrencyFormMainColumn';

const CurrencyForm = ({params}) => {
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
  } = useApiForm(
    setValue,
    params,
    'admin/currencies',
    '/admin/currencies'
  );

  if (params.id) {
    useEffect(() => {
      fetchFormData(`admin/currencies/${params.id}/form-data`, HTTP_METHODS.GET, ['name', 'code', 'symbol', 'roundingPrecision']);
    }, []);
  }

  // console.log(fieldErrors);
  // console.log(Object.values(fieldErrors))
  // if (!isRequestFinished && Object.values(fieldErrors).length === 0) {
  //   return <FormSkeleton rowsCount={3} />
  // }

  return (
    <ApiForm
      apiConfig={getApiConfig()}
      handleSubmit={handleSubmit}
      setError={setError}
      apiRequestCallbacks={defaultApiSuccessCallback}
    >
      <FormLayout
        mainColumn={
          <CurrencyFormMainColumn register={register} fieldErrors={fieldErrors} />
        }
      />
    </ApiForm>
  )
}

export default CurrencyForm;
