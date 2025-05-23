import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import SettingFormMainColumn from '@/admin/features/setting/components/SettingFormMainColumn';
import { useParams } from 'react-router-dom';

const SettingForm = () => {
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
            type: 'custom'
        }
    });

    const { fetchFormData, defaultApiSuccessCallback, getApiConfig, formData, isFormReady } = useApiForm(
        setValue,
        params,
        'admin/settings',
        '/admin/settings',
    );

    useEffect(() => {
        const endpointFormData = params.id ? `admin/settings/${params.id}` : `admin/settings/store-data`;

        fetchFormData(endpointFormData, HTTP_METHODS.GET, ['name', 'value', 'type', 'isProtected', 'isJson']);
    }, []);

    if (!isFormReady) {
        return <FormSkeleton rowsCount={3} />;
    }

    const { isProtected } = formData;

    return (
        <ApiForm
            apiConfig={getApiConfig()}
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={defaultApiSuccessCallback}
        >
            <FormLayout
                pageTitle={params.id ? 'Edytuj Ustawienie' : 'Dodaj ustawienie'}
                mainColumn={
                    <SettingFormMainColumn
                        isProtected={isProtected}
                        register={register}
                        fieldErrors={fieldErrors}
                        formData={formData}
                        control={control}
                    />
                }
            />
        </ApiForm>
    );
};

export default SettingForm;
