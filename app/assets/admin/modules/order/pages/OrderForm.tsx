import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import OrderFormBody from '@admin/modules/order/components/form/OrderFormBody';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';

const OrderForm = () => {
    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/orders',
        redirectSuccessUrl: '/admin/orders',
    });
    const requestConfig = getRequestConfig();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    formState: { errors: fieldErrors },
  } = useForm<OrderFormData>({
    mode: 'onBlur',
  });

  const { isFormInitialize, formData, formContext, getFormData } = useFormInitializer<OrderFormData>();

  useEffect(() => {
      const endpoint = isEditMode ? `admin/orders/${entityId}` : 'admin/orders/store-data';
      const formFieldNames = isEditMode
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
        ] satisfies (keyof OrderFormData)[]
        : [];

      getFormData(endpoint, setValue, formFieldNames);
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
      <FormApiLayout pageTitle={isEditMode ? 'Edytuj zamówienie' : 'Dodaj zamówienie'}>
        <OrderFormBody
          register={register}
          control={control}
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
