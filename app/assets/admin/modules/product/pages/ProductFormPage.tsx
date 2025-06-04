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
import { SettingFormDataInterface } from '@admin/modules/setting/interfaces/SettingFormDataInterface';

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
      const newAttributes: Record<string, { value: any; isCustom: boolean }> = {};

      Object.entries(modifyValues.attributes).forEach(([key, attributeObj]) => {
        const values: any[] = [];

        if (typeof attributeObj === 'object') {
          Object.entries(attributeObj).forEach(([innerKey, innerValue]) => {
            values.push(innerValue?.value);
          });
        }

        const isCustom = !!modifyValues.customAttributes?.[key];

        newAttributes[key] = {
          value: values,
          isCustom,
        };
      });

      modifyValues.attributes = newAttributes;

      delete modifyValues.customAttributes;
    }

    if (modifyValues?.stocks) {
      modifyValues?.stocks.map(stock => {
        const restockDate = stock.restockDate;

        stock.warehouseId = stock.warehouseId.value;
        stock.restockDate = restockDate ? restockDate : null
        return stock;
      });
    }

    if (modifyValues?.brand) {
      modifyValues.brand = modifyValues.brand.value;
    }

    return modifyValues;
  };

  useEffect(() => {
    const endpoint = params.id ? `admin/products/${params.id}` : 'admin/products/store-data';
    const formFieldNames = params.id
      ? [
        'name',
        'slug',
        'metaTitle',
        'metaDescription',
        'description',
        'isActive',
        'mainCategory',
        'categories',
        'tags',
        'brand',
        'stocks',
        'attributes',
        'regularPrice',
        'promotionIsActive',
        'promotionDateRange',
        'promotionReduction',
        'promotionReductionType',
      ]
      : [];

    const formFieldModifiers = [
      {
        fieldName: 'attributes',
        action: (item) => {
          Object.entries(item).forEach(([key, attributeObj]) => {
            let isCustom = false;
            attributeObj.forEach((attrb, keye) => {
              isCustom = attrb.isCustom;
              if (isCustom) {
                setValue(`attributes[${key}].${keye}.value`, attrb.value);
              } else {
                setValue(`attributes[${key}].${keye}`, attrb.value);
              }
            })
            setValue(`customAttributes[${key}]`, isCustom);
          });
        },
      }
    ]

    getFormData(endpoint, setValue, formFieldNames, formFieldModifiers);
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
