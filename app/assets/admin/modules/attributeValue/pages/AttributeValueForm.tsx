import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import AttributeValueFormBody from '@admin/modules/attributeValue/components/AttributeValueFormBody';
import { AttributeValueFormData } from '@admin/modules/attributeValue/interfaces/AttributeValueFormData';

const AttributeValueForm = () => {
    const params = useParams();
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        formState: { errors: fieldErrors },
    } = useForm<AttributeValueFormData>({
        mode: 'onBlur',
        defaultValues: {
            attributeId: Number(params.attributeId) || null,
        },
    });

    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: `admin/attributes/${params.attributeId}/values`,
        redirectSuccessUrl: `/admin/products/attributes/${params.attributeId}/values`,
    });
    const requestConfig = getRequestConfig();
    const { isFormInitialize, getFormData } = useFormInitializer<AttributeValueFormData>();

    useEffect(() => {
        if (isEditMode) {
            const endpoint = `admin/attributes/${params.attributeId}/values/${entityId}`;
            const formFieldNames = isEditMode ? (['value'] satisfies (keyof AttributeValueFormData)[]) : [];

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
            <FormApiLayout pageTitle={params.id ? 'Edytuj wartość' : 'Dodaj wartość'}>
                <AttributeValueFormBody register={register} fieldErrors={fieldErrors} />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default AttributeValueForm;
