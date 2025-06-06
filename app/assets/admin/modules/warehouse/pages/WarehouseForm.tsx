import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import { UserFormDataInterface } from '@admin/modules/user/interfaces/UserFormDataInterface';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import WarehouseFormBody from '@admin/modules/warehouse/components/WarehouseFormBody';
import { CustomerFormDataInterface } from '@admin/modules/customer/interfaces/CustomerFormDataInterface';

const WarehouseForm = () => {
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

  const baseApiUrl = 'admin/warehouses';
  const redirectSuccessUrl = '/admin/warehouses';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData, formContext, formData } = useFormInitializer<UserFormDataInterface>();

  useEffect(() => {
    const endpoint = isEditMode ?  `admin/warehouses/${params.id}` : 'admin/warehouses/store-data'
    const formFieldNames = isEditMode
      ?  ['name', 'isActive', 'country', 'street', 'city', 'postalCode', 'description']
      : []

    getFormData(endpoint, setValue, formFieldNames);
  }, []);

  if (!isFormInitialize) {
    return <FormSkeleton rowsCount={12} />;
  }

  const modifySubmitValues = (values: CustomerFormDataInterface) => {
    const data = {...values};

    if (typeof data.country === 'object' && data.country !== null) {
      data.country = values.country?.value;
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
      <FormApiLayout pageTitle={isEditMode ? 'Edytuj magazyn' : 'Dodaj magazyn'}>
        <WarehouseFormBody
          control={control}
          register={register}
          fieldErrors={fieldErrors}
          formContext={formContext}
          formData={formData}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default WarehouseForm;
