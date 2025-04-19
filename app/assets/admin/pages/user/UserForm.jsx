import ApiForm from '@/admin/components/form/ApiForm';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import FormLayout from '@/admin/layouts/FormLayout';
import UserFormMainColumn from '@/admin/features/user/components/UserFormMainColumn';
import UserFormSideColumn from '@/admin/features/user/components/UserFormSideColumn';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';
import useApiForm from '@/admin/hooks/useApiForm';

const UserForm = () => {
    const params = useParams();
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        control,
        formState: { errors: fieldErrors },
    } = useForm({
        mode: 'onBlur',
        defaultValues: {
            id: Number(params.id) ?? null,
        },
    });

    const { fetchFormData, defaultApiSuccessCallback, getApiConfig, formData, setFormData, isFormReady } = useApiForm(
        setValue,
        params,
        'admin/users',
        '/admin/users',
    );

    if (params.id) {
        useEffect(() => {
            fetchFormData(`admin/users/${params.id}/form-data`, HTTP_METHODS.GET, [
                'name',
                'value',
                'type',
                'isProtected',
            ]);
        }, []);
    }

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
                pageTitle={params.id ? 'Edycja użytkownika' : 'Dodaj użytkownika'}
                mainColumn={
                    <UserFormMainColumn
                        register={register}
                        fieldErrors={fieldErrors}
                        control={control}
                        params={params}
                    />
                }
                sideColumn={
                    <UserFormSideColumn
                        register={register}
                        setValue={setValue}
                        userData={formData}
                        setUserData={setFormData}
                    />
                }
            />
        </ApiForm>
    );
};

export default UserForm;
