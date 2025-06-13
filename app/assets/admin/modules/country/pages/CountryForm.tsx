import { useForm } from 'react-hook-form';
import { CountryFormData } from '@admin/modules/country/interfaces/CountryFormData';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import CountryFormBody from '@admin/modules/country/components/CountryFormBody';

const CountryForm = () => {
    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/countries',
        redirectSuccessUrl: '/admin/countries',
    });
    const requestConfig = getRequestConfig();
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        formState: { errors: fieldErrors },
    } = useForm<CountryFormData>({
        mode: 'onBlur',
        defaultValues: {
            id: entityId,
        },
    });

    const { isFormInitialize, getFormData } = useFormInitializer<CountryFormData>();

    useEffect(() => {
        if (isEditMode) {
            const endpoint = `admin/countries/${entityId}`;
            const formFieldNames = ['id', 'name', 'code', 'isActive'] satisfies (keyof CountryFormData)[];

            getFormData(endpoint, setValue, formFieldNames);
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
            <FormApiLayout pageTitle={isEditMode ? 'Edytuj kraj' : 'Dodaj kraj'}>
                <CountryFormBody register={register} fieldErrors={fieldErrors} />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default CountryForm;
