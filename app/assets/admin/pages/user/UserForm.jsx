import ApiForm from '@/admin/components/form/ApiForm';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import FormLayout from '@/admin/layouts/FormLayout';
import UserFormMainColumn from '@/admin/features/user/components/UserFormMainColumn';
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
            id: params.id ? Number(params.id) : null,
        },
    });

    const { fetchFormData, defaultApiSuccessCallback, getApiConfig, formData, setFormData, isFormReady } = useApiForm(
        setValue,
        params,
        'admin/users',
        '/admin/users',
    );


        useEffect(() => {
            if (params.id) {
                fetchFormData(`admin/users/${params.id}`, HTTP_METHODS.GET, [
                    'roles',
                    'firstname',
                    'surname',
                    'email',
                    'isActive',
                ]);
            } else {
                fetchFormData(`admin/users/store-data`, HTTP_METHODS.GET);
            }

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
                pageTitle={params.id ? 'Edycja użytkownika' : 'Dodaj użytkownika'}
                mainColumn={
                    <UserFormMainColumn
                        register={register}
                        fieldErrors={fieldErrors}
                        control={control}
                        params={params}
                        setValue={setValue}
                        formData={formData}
                        setFormData={setFormData}
                    />
                }
            />
        </ApiForm>
    );
};

export default UserForm;
