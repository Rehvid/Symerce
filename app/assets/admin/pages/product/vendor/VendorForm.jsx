import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import React, { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import VendorFormSideColumn from '@/admin/features/product/vendor/components/VendorFormSideColumn';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';
import { useParams } from 'react-router-dom';

const VendorForm = () => {
    const params = useParams();
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        formState: { errors: fieldErrors },
    } = useForm({
        mode: 'onBlur',
    });

    const { fetchFormData, defaultApiSuccessCallback, getApiConfig, formData, setFormData, isFormReady } = useApiForm(
        setValue,
        params,
        'admin/vendors',
        '/admin/products/vendors',
    );

    if (params.id) {
        useEffect(() => {
            fetchFormData(`admin/vendors/${params.id}/form-data`, HTTP_METHODS.GET, ['name']);
        }, []);
    }

    if (!isFormReady) {
        return <FormSkeleton rowsCount={3} />;
    }

    return (
        <ApiForm
            apiConfig={getApiConfig()}
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={defaultApiSuccessCallback}
        >
            <FormLayout
                pageTitle={params.id ? 'Edytuj Proudcenta' : 'Dodaj Producenta'}
                mainColumn={
                    <Input
                        {...register('name', {
                            ...validationRules.required(),
                            ...validationRules.minLength(3),
                        })}
                        type="text"
                        id="name"
                        label="Nazwa"
                        hasError={!!fieldErrors?.name}
                        errorMessage={fieldErrors?.name?.message}
                        isRequired
                    />
                }
                sideColumn={
                    <VendorFormSideColumn
                        register={register}
                        formData={formData}
                        setValue={setValue}
                        setFormData={setFormData}
                    />
                }
            />
        </ApiForm>
    );
};

export default VendorForm;
