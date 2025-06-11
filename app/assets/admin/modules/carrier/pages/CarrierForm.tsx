import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import { CarrierFormData } from '@admin/modules/carrier/interfaces/CarrierFormData';
import CarrierFormBody from '@admin/modules/carrier/components/CarrierFormBody';


const CarrierForm = () => {
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    watch,
    control,
    formState: { errors: fieldErrors },
  } = useForm<CarrierFormData>({
    mode: 'onBlur',
  });

    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/carriers',
        redirectSuccessUrl: '/admin/carriers',
    });
    const requestConfig = getRequestConfig();

  const { isFormInitialize, getFormData, formData } = useFormInitializer<CarrierFormData>();

  useEffect(() => {
    if (isEditMode) {
      const endpoint = `admin/carriers/${entityId}`;
      const formFieldNames  = ['name', 'isActive', 'fee', 'isExternal', 'externalData'] satisfies (keyof CarrierFormData)[];

      getFormData(endpoint, setValue, formFieldNames);
    }
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
      <FormApiLayout pageTitle={isEditMode ? 'Edytuj przewoźnika' : 'Dodaj przewoźnika'}>
        <CarrierFormBody
          register={register}
          fieldErrors={fieldErrors}
          formData={formData}
          setValue={setValue}
          control={control}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default CarrierForm;
