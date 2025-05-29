import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import ProductFormBody from '@admin/modules/product/components/ProductFormBody';
import useApiFormSubmit from '@admin/shared/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/shared/hooks/form/useFormInitializer';
import FormSkeleton from '@admin/components/skeleton/FormSkeleton';
import { useEffect } from 'react';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import FormWrapper from '@admin/shared/components/form/FormWrapper';

const ProductFormPage = () => {
  const params = useParams();
  const {
    register,
    handleSubmit,
    setValue,
    setError,
    control,
    watch,
    formState: { errors: fieldErrors },
  } = useForm<ProductFormDataInterface>({
    mode: 'onBlur',
    defaultValues: {
      promotionSource: 'product_tab'
    }
  });

  const baseApiUrl = 'admin/products';
  const redirectSuccessUrl = '/admin/products';
  const { getApiConfig, defaultApiSuccessCallback } = useApiFormSubmit(baseApiUrl, redirectSuccessUrl, params);
  const { isFormInitialize, formData, formContext, getFormData } = useFormInitializer<ProductFormDataInterface>();

  const modifySubmitValues = (values: ProductFormDataInterface) => {
    const modifyValues = { ...values };

    if (modifyValues?.attributes) {
      modifyValues.attributes = {
        ...modifyValues.attributes,
      };
    }

    return modifyValues;
  };

  useEffect(() => {
    const endpoint = params.id ? `admin/products/${params.id}` : 'admin/products/store-data';
    const formFieldNames = params.id
      ? [
        'name',
        'slug',
        'description',
        'isActive',
        'mainCategory',
        'categories',
        'tags',
        'vendor',
        'attributes',
        'deliveryTime',
        'regularPrice',
        'promotionIsActive',
        'promotionDateRange',
        'promotionReduction',
        'promotionReductionType',
        'stockAvailableQuantity',
        'stockLowStockThreshold',
        'stockMaximumStockLevel',
        'stockEan13',
        'stockSku',
        'stockNotifyOnLowStock',
        'stockVisibleInStore'
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
      modifySubmitValues={modifySubmitValues}
    >
      <FormApiLayout pageTitle={params.id ? 'Edytuj Produkt' : 'Dodaj Produkt'}>
        <ProductFormBody
          register={register}
          control={control}
          watch={watch}
          setValue={setValue}
          fieldErrors={fieldErrors}
          formData={formData}
          formContext={formContext}
        />
      </FormApiLayout>
    </FormWrapper>
  );
}

export default ProductFormPage;
