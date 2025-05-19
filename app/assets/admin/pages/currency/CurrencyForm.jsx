import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import CurrencyFormMainColumn from '@/admin/features/currency/components/CurrencyFormMainColumn';
import { useParams } from 'react-router-dom';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';

const CurrencyForm = () => {
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

    const { fetchFormData, defaultApiSuccessCallback, getApiConfig, isFormReady } = useApiForm(
        setValue,
        params,
        'admin/currencies',
        '/admin/currencies',
    );

    if (params.id) {
        useEffect(() => {
            fetchFormData(`admin/currencies/${params.id}`, HTTP_METHODS.GET, [
                'name',
                'code',
                'symbol',
                'roundingPrecision',
            ]);
        }, []);
    }

    if (!isFormReady) {
        return <FormSkeleton rowsCount={4} />;
    }

    return (
        <ApiForm
            apiConfig={getApiConfig()}
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={defaultApiSuccessCallback}
        >
            <FormLayout
                pageTitle={params.id ? 'Edytuj Walute' : 'Dodaj Walute'}
                mainColumn={<CurrencyFormMainColumn register={register} fieldErrors={fieldErrors} />}
            />
        </ApiForm>
    );
};

export default CurrencyForm;
