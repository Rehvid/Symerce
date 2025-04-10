import React, { useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';
import CategoryFormSideColumn from './CategoryFormSideColumn';
import CategoryFormMainColumn from './CategoryFormMainColumn';
import AppForm from '@/admin/components/form/AppForm';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { useLocation, useNavigate } from 'react-router-dom';
import { useApi } from '@/admin/hooks/useApi';
import { useCreateNotification } from '@/admin/hooks/useCreateNotification';
import { NOTIFICATION_TYPES } from '@/admin/constants/notificationConstants';
import AppFormFixedButton from '@/admin/components/form/AppFormFixedButton';

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
                }
            },
        });
    }, []);

    const apiRequestCallbacks = {
        onSuccess: ({ data, message }) => {
            if (data.id) {
                addNotification(message, NOTIFICATION_TYPES.SUCCESS);
                navigate(`/admin/categories/${data.id}/edit`, { replace: true });
            }
        },
    };

    const apiConfig = params.id
        ? createApiConfig(`admin/categories/${params.id}`, HTTP_METHODS.PUT)
        : createApiConfig('admin/categories', HTTP_METHODS.POST);

    if (!isRequestFinished) {
        return <>...</>;
    }

    return (
        <AppForm
            apiConfig={apiConfig}
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={apiRequestCallbacks}
        >
            <div className="flex flex-row gap-4 mt-5">
                <div className="flex flex-col w-full gap-4">
                    <CategoryFormMainColumn
                        register={register}
                        errors={fieldErrors}
                        setValue={setValue}
                        categoryData={categoryData}
                        params={params}
                        watch={watch}
                        control={control}
                    />
                </div>
                <CategoryFormSideColumn register={register} control={control} />

                <AppFormFixedButton />
            </div>
        </AppForm>
    );
};

export default CategoryForm;
