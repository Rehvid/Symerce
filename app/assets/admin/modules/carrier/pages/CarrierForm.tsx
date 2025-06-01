import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import { BrandFormDataInterface } from '@admin/modules/brand/interfaces/BrandFormDataInterface';
import useApiFormSubmit from '@admin/shared/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/shared/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/shared/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import { CarrierFormDataInterface } from '@admin/modules/carrier/interfaces/CarrierFormDataInterface';
import CarrierFormBody from '@admin/modules/carrier/components/CarrierFormBody';


const CarrierForm = () => {
  const params = useParams();
  const isEditMode = params.id ?? false;
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    watch,
    control,
    formState: { errors: fieldErrors },
  } = useForm<CarrierFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/carriers';
  const redirectSuccessUrl = '/admin/carriers';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData, formData } = useFormInitializer<CarrierFormDataInterface>();

  useEffect(() => {
    if (isEditMode) {
      const endpoint = `admin/carriers/${params.id}`;
      const formFieldNames  = ['name', 'isActive', 'fee', 'isExternal', 'externalData'];

      getFormData(endpoint, setValue, formFieldNames);
    }

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
      <FormApiLayout pageTitle={isEditMode ? 'Edytuj przewoźnika' : 'Dodaj przewoźnika'}>
        <CarrierFormBody
          register={register}
          fieldErrors={fieldErrors}
          formData={formData}
          setValue={setValue}
          watch={watch}
          control={control}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default CarrierForm;
