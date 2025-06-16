import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import { CurrencyFormData } from '@admin/modules/currency/interfaces/CurrencyFormData';
import CurrencyFormBody from '@admin/modules/currency/components/CurrencyFormBody';

const CurrencyFormPage = () => {
    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/currencies',
        redirectSuccessUrl: '/admin/currencies',
    });
    const requestConfig = getRequestConfig();

    const {
        register,
        handleSubmit,
        setValue,
        setError,
        formState: { errors: fieldErrors },
    } = useForm<CurrencyFormData>({
        mode: 'onBlur',
        defaultValues: {
            id: entityId
        }
    });

    const { isFormInitialize, getFormData } = useFormInitializer<CurrencyFormData>();

    useEffect(() => {
        if (isEditMode) {
            getFormData(`admin/currencies/${entityId}`, setValue, [
                'code',
                'name',
                'symbol',
                'roundingPrecision',
            ] satisfies (keyof CurrencyFormData)[]);
        }
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
            <FormApiLayout pageTitle={isEditMode ? 'Edytuj walute' : 'Dodaj walute'}>
                <CurrencyFormBody register={register} fieldErrors={fieldErrors} />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default CurrencyFormPage;
