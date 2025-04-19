import { useEffect } from 'react';
import { useForm } from 'react-hook-form';
import ApiForm from '@/admin/components/form/ApiForm';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { useParams } from 'react-router-dom';
import FormLayout from '@/admin/layouts/FormLayout';
import CategoryFormMainColumn from '@/admin/features/category/components/CategoryFormMainColumn';
import CategoryFormSideColumn from '@/admin/features/category/components/CategoryFormSideColumn';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';
import useApiForm from '@/admin/hooks/useApiForm';

const CategoryForm = () => {
    const params = useParams();

    const {
        register,
        handleSubmit,
        setValue,
        setError,
        watch,
        control,
        formState: { errors: fieldErrors },
    } = useForm();

    const { fetchFormData, defaultApiSuccessCallback, getApiConfig, formData, setFormData, isFormReady } = useApiForm(
        setValue,
        params,
        'admin/categories',
        '/admin/categories',
    );

    useEffect(() => {
        const endPoint = params.id ? `admin/categories/${params.id}/form-data` : 'admin/categories/form-data';
        // fetchFormData(endPoint, HTTP_METHODS.GET, ['name', 'isActive', 'description', 'parentCategoryId', 'slug']); //TODO: Dane źle są pobierane
    }, []);

    if (!isFormReady) {
        return <FormSkeleton rowsCount={8} />;
    }

    return (
        <ApiForm
            apiConfig={getApiConfig()}
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={defaultApiSuccessCallback}
        >
            <FormLayout
                pageTitle={params.id ? 'Edytuj Kategorie' : 'Dodaj Kategorie'}
                mainColumn={
                    <CategoryFormMainColumn
                        register={register}
                        errors={fieldErrors}
                        setValue={setValue}
                        categoryData={formData}
                        params={params}
                        watch={watch}
                        control={control}
                    />
                }
                sideColumn={
                    <CategoryFormSideColumn
                        register={register}
                        categoryFormData={formData}
                        setCategoryFormData={setFormData}
                        setValue={setValue}
                    />
                }
            />
        </ApiForm>
    );
};

export default CategoryForm;
