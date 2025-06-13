import { useParams } from 'react-router-dom';
import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import AttributeFormBody from '@admin/modules/attribute/components/AttributeFormBody';
import { AttributeFormData } from '@admin/modules/attribute/interfaces/AttributeFormData';

const AttributeForm = () => {
    const params = useParams();
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        control,
        formState: { errors: fieldErrors },
    } = useForm<AttributeFormData>({
        mode: 'onBlur',
    });
    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/attributes',
        redirectSuccessUrl: '/admin/products/attributes',
    });
    const requestConfig = getRequestConfig();

    const { isFormInitialize, getFormData, formContext } = useFormInitializer<AttributeFormData>();

    useEffect(() => {
        const formFieldNames = isEditMode ? (['type', 'name', 'isActive'] satisfies (keyof AttributeFormData)[]) : [];

        getFormData(
            isEditMode ? `admin/attributes/${entityId}` : `admin/attributes/store-data`,
            setValue,
            formFieldNames,
        );
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
            <FormApiLayout pageTitle={params.id ? 'Edytuj atrybut' : 'Dodaj atrytbut'}>
                <AttributeFormBody
                    register={register}
                    fieldErrors={fieldErrors}
                    control={control}
                    formContext={formContext}
                />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default AttributeForm;
