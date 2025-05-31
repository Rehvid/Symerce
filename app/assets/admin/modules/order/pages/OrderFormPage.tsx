import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/shared/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/shared/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/shared/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import OrderFormBody from '@admin/modules/order/components/form/OrderFormBody';
import { OrderFormDataInterface } from '@admin/modules/order/interfaces/OrderFormDataInterface';
import { CustomerFormDataInterface } from '@admin/modules/customer/interfaces/CustomerFormDataInterface';

const OrderFormPage = () => {
  const params = useParams();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    watch,
    formState: { errors: fieldErrors },
  } = useForm<OrderFormDataInterface>({
    mode: 'onBlur',
  });

  const baseApiUrl = 'admin/orders';
  const redirectSuccessUrl = '/admin/orders';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, formData, formContext, getFormData } = useFormInitializer<OrderFormDataInterface>();
  const isEditMode = params.id ?? false;
  console.log('watch', watch());

  useEffect(() => {
      const endpoint = params.id ? `admin/orders/${params.id}` : 'admin/orders/store-data';
      const formFieldNames = params.id
        ? [
          'checkoutStep',
          'status',
          'carrierId',
          'paymentMethodId',
          'isInvoice',
          'firstname',
          'surname',
          'email',
          'phone',
          'street',
          'postalCode',
          'city',
          'deliveryInstructions',
          'country',
          'invoiceStreet',
          'invoicePostalCode',
          'invoiceCity',
          'invoiceCountry',
          'invoiceCompanyName',
          'invoiceCompanyTaxId',
          'products',
        ]
        : [];

      getFormData(endpoint, setValue, formFieldNames);
  }, []);

  if (!isFormInitialize) {
    return <FormSkeleton rowsCount={12} />;
  }

  const modifySubmitValues = (values: OrderFormDataInterface) => {
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
      <FormApiLayout pageTitle={params.id ? 'Edytuj zamówienie' : 'Dodaj zamówienie'}>
        <OrderFormBody
          register={register}
          control={control}
          watch={watch}
          setValue={setValue}
          fieldErrors={fieldErrors}
          formData={formData}
          formContext={formContext}
          isEditMode={isEditMode}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default OrderFormPage;
