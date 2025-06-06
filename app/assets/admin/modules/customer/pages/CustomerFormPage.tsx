import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import CustomerFormBody from '@admin/modules/customer/components/CustomerFormBody';
import { CustomerFormDataInterface } from '@admin/modules/customer/interfaces/CustomerFormDataInterface';


const CustomerFormPage = () => {
  const params = useParams();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    watch,
    control,
    formState: { errors: fieldErrors },
  } = useForm<CustomerFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/customers';
  const redirectSuccessUrl = '/admin/customers';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData, formData, formContext } = useFormInitializer<CustomerFormDataInterface>();
  const isEditMode = params.id ?? false;

  useEffect(() => {
      const endpoint = isEditMode ? `admin/customers/${params.id}` : `admin/customers/store-data`;
      const formFieldNames = isEditMode ? [
        'firstname',
        'surname',
        'email',
        'phone',
        'isActive',
        'isDelivery',
        'isInvoice',
        'street',
        'postalCode',
        'city',
        'country',
        'deliveryInstructions',
        'invoiceStreet',
        'invoicePostalCode',
        'invoiceCompanyName',
        'invoiceCompanyTaxId',
        'invoiceCity',
        'invoiceCountry'
      ] : [];

      getFormData(endpoint, setValue, formFieldNames);
  }, []);

  if (!isFormInitialize) {
    return <FormSkeleton rowsCount={12} />;
  }

  console.log(watch());

  const modifySubmitValues = (values: CustomerFormDataInterface) => {
      const data = {...values};

      if (typeof data.country === 'object' && data.country !== null) {
        data.country = values.country?.value;
      }
      if (typeof data.invoiceCountry=== 'object' && data.invoiceCountry !== null) {
        data.invoiceCountry = values?.invoiceCountry.value;
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
      <FormApiLayout pageTitle={params.id ? 'Edytuj klienta' : 'Dodaj klienta'}>
        <CustomerFormBody
          register={register}
          fieldErrors={fieldErrors}
          isEditMode={isEditMode}
          watch={watch}
          control={control}
          formData={formData}
          formContext={formContext}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default CustomerFormPage;
