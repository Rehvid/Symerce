import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import ProductFormMainColumn from '@/admin/features/product/components/ProductFormMainColumn';
import ProductFormSideColumn from '@/admin/features/product/components/ProductFormSideColumn';

const ProductForm = () => {
    const params = useParams();

    const {
        register,
        handleSubmit,
        setValue,
        setError,
        control,
      watch,
        formState: { errors: fieldErrors },
    } = useForm({
        mode: 'onBlur',
    });

    const { fetchFormData, defaultApiSuccessCallback, getApiConfig, formData, setFormData, isFormReady } = useApiForm(
      setValue,
      params,
      'admin/products',
      '/admin/products',
    );

    useEffect(() => {
        const endPoint = params.id ? `admin/products/${params.id}/form-data` : 'admin/products/form-data';
        const formFieldNames = params.id
          ? [
              'name',
              'description',
              'isActive',
              'quantity',
              'slug',
              'regularPrice',
              'discountPrice',
              'vendor',
              'tags',
              'categories',
              'deliveryTimes',
              'attributes'
          ]
          : [];

        fetchFormData(endPoint, HTTP_METHODS.GET, formFieldNames);
    }, []);

    if (!isFormReady) {
        return <FormSkeleton rowsCount={8} />;
    }

    console.log(watch());

    return (
      <ApiForm
        apiConfig={getApiConfig()}
        handleSubmit={handleSubmit}
        setError={setError}
        apiRequestCallbacks={defaultApiSuccessCallback}
      >
          <FormLayout
            pageTitle={params.id ? 'Edytuj Produkt' : 'Dodaj Produkt'}
            mainColumn={
                <ProductFormMainColumn
                    register={register}
                    control={control}
                    fieldErrors={fieldErrors}
                    setValue={setValue}
                    setFormData={setFormData}
                    formData={formData}
                />
            }
            sideColumn={
                <ProductFormSideColumn
                  register={register}
                  control={control}
                  fieldErrors={fieldErrors}
                  formData={formData}
                  setValue={setValue}
                />
            }
          />
      </ApiForm>
    );
};

export default ProductForm;
