import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/shared/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/shared/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/shared/components/form/FormWrapper';
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
    formState: { errors: fieldErrors },
  } = useForm<CustomerFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/customers';
  const redirectSuccessUrl = '/admin/customers';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, getFormData } = useFormInitializer<CustomerFormDataInterface>();

  useEffect(() => {
    if (params.id) {
      const endpoint = `admin/customers/${params.id}`;
      const formFieldNames = [
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
        'deliveryInstructions',
        'invoiceStreet',
        'invoicePostalCode',
        'invoiceCompanyName',
        'invoiceCompanyTaxId',
        'invoiceCity'
      ]

      getFormData(endpoint, setValue, formFieldNames);
    }
  }, []);

  if (!isFormInitialize) {
    return <FormSkeleton rowsCount={12} />;
  }

  const isEditMode = params.id ?? false;

  return (
    <FormWrapper
      apiConfig={getApiConfig()}
      handleSubmit={handleSubmit}
      setError={setError}
      apiRequestCallbacks={defaultApiSuccessCallback}
    >
      <FormApiLayout pageTitle={params.id ? 'Edytuj klienta' : 'Dodaj klienta'}>
        <CustomerFormBody register={register} fieldErrors={fieldErrors} isEditMode={isEditMode} watch={watch} />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default CustomerFormPage;
