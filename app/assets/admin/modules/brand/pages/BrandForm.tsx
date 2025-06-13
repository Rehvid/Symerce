import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import BrandFormBody from '@admin/modules/brand/components/BrandFormBody';
import { BrandFormData } from '@admin/modules/brand/interfaces/BrandFormData';

const BrandForm = () => {
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        formState: { errors: fieldErrors },
    } = useForm<BrandFormData>({
        mode: 'onBlur',
    });

    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/brands',
        redirectSuccessUrl: '/admin/brands',
    });
    const requestConfig = getRequestConfig();

    const { isFormInitialize, getFormData, formData } = useFormInitializer<BrandFormData>();

    useEffect(() => {
        if (isEditMode) {
            const endpoint = `admin/brands/${entityId}`;
            const formFieldNames = ['name', 'isActive'] satisfies (keyof BrandFormData)[];

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
            <FormApiLayout pageTitle={isEditMode ? 'Edytuj marke' : 'Dodaj marke'}>
                <BrandFormBody register={register} fieldErrors={fieldErrors} formData={formData} setValue={setValue} />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default BrandForm;
