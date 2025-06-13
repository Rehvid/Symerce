import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import CategoryFormBody from '@admin/modules/category/components/CategoryFormBody';
import { CategoryFormData } from '@admin/modules/category/interfaces/CategoryFormData';

const CategoryForm = () => {
    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/categories',
        redirectSuccessUrl: '/admin/categories',
    });
    const requestConfig = getRequestConfig();

    const {
        register,
        handleSubmit,
        setValue,
        setError,
        control,
        watch,
        formState: { errors: fieldErrors },
    } = useForm<CategoryFormData>({
        mode: 'onBlur',
        defaultValues: {
            id: entityId,
        },
    });

    const { isFormInitialize, getFormData, formData, formContext } = useFormInitializer<CategoryFormData>();

    const getFormFieldNames = (hasId: boolean): (keyof CategoryFormData)[] => {
        if (!hasId) return [];
        return ['name', 'isActive', 'description', 'parentCategoryId', 'slug', 'metaTitle', 'metaDescription'];
    };

    useEffect(() => {
        getFormData(
            isEditMode ? `admin/categories/${entityId}` : 'admin/categories/store-data',
            setValue,
            getFormFieldNames(isEditMode),
        );
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
            <FormApiLayout pageTitle={isEditMode ? 'Edytuj kategorie' : 'Dodaj kategorie'}>
                <CategoryFormBody
                    register={register}
                    fieldErrors={fieldErrors}
                    control={control}
                    formData={formData}
                    formContext={formContext}
                    entityId={entityId}
                    watch={watch}
                    setValue={setValue}
                />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default CategoryForm;
