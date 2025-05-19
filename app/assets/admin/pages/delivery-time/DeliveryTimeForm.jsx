import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import DeliveryTimeFormMainColumn from '@/admin/features/delivery-time/components/DeliveryTimeFormMainColumn';
import { useParams } from 'react-router-dom';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';

const DeliveryTimeForm = () => {
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
    });

    const { fetchFormData, defaultApiSuccessCallback, getApiConfig, formData, isFormReady } = useApiForm(
        setValue,
        params,
        'admin/delivery-time',
        '/admin/delivery-time',
    );

    useEffect(() => {
        const endPoint = params.id ? `admin/delivery-time/${params.id}` : 'admin/delivery-time/store-data';
        const formFieldNames = params.id ? ['label', 'minDays', 'maxDays', 'type', 'isActive'] : [];

        fetchFormData(endPoint, HTTP_METHODS.GET, formFieldNames);
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
                pageTitle={params.id ? 'Edytuj Czas dostawy' : 'Dodaj czas dostawy'}
                mainColumn={
                    <DeliveryTimeFormMainColumn
                        register={register}
                        fieldErrors={fieldErrors}
                        formData={formData}
                        setValue={setValue}
                        control={control}
                    />
                }
            />
        </ApiForm>
    );
};
export default DeliveryTimeForm;
