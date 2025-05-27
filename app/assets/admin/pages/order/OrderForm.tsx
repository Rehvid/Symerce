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

const OrderForm = () => {
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
    defaultValues: {
      cartToken: 'should not be mandatory!',
      deliveryCarrier: 'PL'
    }
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
          'invoiceStreet',
          'invoicePostalCode',
          'invoiceCity',
          'companyName',
          'companyTaxId',
          'products'
        ]
        : [];

      getFormData(endpoint, setValue, formFieldNames);
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

export default OrderForm;
