import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import TagFormBody from '@admin/modules/tag/components/TagFormBody';
import { TagFormData } from '@admin/modules/tag/interfaces/TagFormData';

const TagForm = () => {
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        control,
        formState: { errors: fieldErrors },
    } = useForm<TagFormData>({
        mode: 'onBlur',
    });

    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/tags',
        redirectSuccessUrl: '/admin/tags',
    });
    const requestConfig = getRequestConfig();

    const { isFormInitialize, getFormData } = useFormInitializer<TagFormData>();

    useEffect(() => {
        if (isEditMode) {
            const endpoint = `admin/tags/${entityId}`;
            const formFieldNames = ['name', 'backgroundColor', 'textColor', 'isActive'] satisfies (keyof TagFormData)[];

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
            <FormApiLayout pageTitle={isEditMode ? 'Edytuj tag' : 'Dodaj tag'}>
                <TagFormBody register={register} fieldErrors={fieldErrors} control={control} />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default TagForm;
