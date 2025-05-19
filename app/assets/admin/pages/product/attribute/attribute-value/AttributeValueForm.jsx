import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import { useEffect } from 'react';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { useParams } from 'react-router-dom';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';

const AttributeValueForm = () => {
    const params = useParams();
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        formState: { errors: fieldErrors },
    } = useForm({
        mode: 'onBlur',
        defaultValues: {
            attributeId: Number(params.attributeId) || null,
        },
    });

    const { fetchFormData, defaultApiSuccessCallback, getApiConfig, isFormReady } = useApiForm(
        setValue,
        params,
        `admin/attributes/${params.attributeId}/values`,
        `/admin/products/attributes/${params.attributeId}/values`,
    );

    if (params.id) {
        useEffect(() => {
            fetchFormData(`admin/attributes/${params.attributeId}/values/${params.id}`, HTTP_METHODS.GET, [
                'value',
            ]);
        }, []);
    }

    if (!isFormReady) {
        return <FormSkeleton rowsCount={2} />;
    }

    return (
        <ApiForm
            apiConfig={getApiConfig()}
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={defaultApiSuccessCallback}
        >
            <FormLayout
                pageTitle={params.id ? 'Edytuj wartość' : 'Dodaj wartość'}
                mainColumn={
                    <Input
                        {...register('value', {
                            ...validationRules.required(),
                            ...validationRules.minLength(3),
                        })}
                        type="text"
                        id="value"
                        label="Wartość"
                        hasError={!!fieldErrors?.value}
                        errorMessage={fieldErrors?.value?.message}
                        isRequired
                    />
                }
            />
        </ApiForm>
    );
};

export default AttributeValueForm;
