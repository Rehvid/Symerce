import React, { useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';
import CategoryFormSideColumn from './CategoryFormSideColumn';
import CategoryFormMainColumn from './CategoryFormMainColumn';
import ApiForm from '@/admin/components/form/ApiForm';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { useLocation, useNavigate } from 'react-router-dom';
import { useApi } from '@/admin/hooks/useApi';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import { NOTIFICATION_TYPES } from '@/admin/constants/notificationConstants';
import FormFooterActions from '@/admin/components/form/FormFooterActions';
import FormLayout from '@/admin/layouts/FormLayout';

const CategoryForm = ({ params }) => {
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        watch,
        control,
        formState: { errors: fieldErrors },
    } = useForm();
    const [categoryData, setCategoryData] = useState({});
    const navigate = useNavigate();
    const { handleApiRequest, isRequestFinished } = useApi();
    const { addNotification } = useCreateNotification();

    useEffect(() => {
        const endpoint = params.id ? `admin/categories/${params.id}/form-data` : 'admin/categories/form-data';
        const createConfig = createApiConfig(endpoint, HTTP_METHODS.GET);
        handleApiRequest(createConfig, {
            onSuccess: ({ data }) => {
                const { formData } = data;
                if (formData) {
                    setCategoryData(formData);
                    setValue('name', formData.name);
                    setValue('description', formData.description);
                    setValue('isActive', formData.isActive);
                    setValue('parentCategoryId', formData.parentCategoryId);
                    setValue('slug', formData.slug);
                }
            },
        });
    }, []);

    const apiRequestCallbacks = {
        onSuccess: ({ data, message }) => {
            addNotification(message, NOTIFICATION_TYPES.SUCCESS);
            if (!params.id && data.id) {
                navigate(`/admin/categories/${data.id}/edit`, { replace: true });
            }
            navigate(`/admin/categories`, { replace: true });
        },
    };

    const apiConfig = params.id
        ? createApiConfig(`admin/categories/${params.id}`, HTTP_METHODS.PUT)
        : createApiConfig('admin/categories', HTTP_METHODS.POST);

    if (!isRequestFinished) {
        return <>...</>;
    }

    return (
        <ApiForm
            apiConfig={apiConfig}
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={apiRequestCallbacks}
        >
            <FormLayout
                mainColumn={
                    <CategoryFormMainColumn
                      register={register}
                      errors={fieldErrors}
                      setValue={setValue}
                      categoryData={categoryData}
                      params={params}
                      watch={watch}
                      control={control}
                    />
                }
                sideColumn={
                    <CategoryFormSideColumn
                      register={register}
                      categoryFormData={categoryData}
                      setCategoryFormData={setCategoryData}
                      setValue={setValue}
                    />
                }
            />
        </ApiForm>
    );
};

export default CategoryForm;
