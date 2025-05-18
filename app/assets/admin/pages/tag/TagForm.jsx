import { useForm } from 'react-hook-form';
import useApiForm from '@/admin/hooks/useApiForm';
import { useEffect } from 'react';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import ApiForm from '@/admin/components/form/ApiForm';
import FormLayout from '@/admin/layouts/FormLayout';
import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import { useParams } from 'react-router-dom';
import FormSkeleton from '@/admin/components/skeleton/FormSkeleton';
import LabelNameIcon from '@/images/icons/label-name.svg';

const TagForm = () => {
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
        'admin/tags',
        '/admin/tags',
    );

    if (params.id) {
        useEffect(() => {
            fetchFormData(`admin/tags/${params.id}`, HTTP_METHODS.GET, ['name']);
        }, []);
    }

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
                pageTitle={params.id ? 'Edytuj Tag' : 'Dodaj Tag'}
                mainColumn={
                    <Input
                        {...register('name', {
                            ...validationRules.required(),
                            ...validationRules.minLength(3),
                        })}
                        type="text"
                        id="name"
                        label="Nazwa"
                        hasError={!!fieldErrors?.name}
                        errorMessage={fieldErrors?.name?.message}
                        isRequired
                        icon={<LabelNameIcon className="text-gray-500 w-[24px] h-[24px]" />}
                    />
                }
            />
        </ApiForm>
    );
};

export default TagForm;
