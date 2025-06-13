import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import WarehouseFormBody from '@admin/modules/warehouse/components/WarehouseFormBody';
import { WarehouseFormData } from '@admin/modules/warehouse/interfaces/WarehouseFormData';

const WarehouseForm = () => {
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        control,
        formState: { errors: fieldErrors },
    } = useForm<WarehouseFormData>({
        mode: 'onBlur',
    });

    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/warehouses',
        redirectSuccessUrl: '/admin/warehouses',
    });
    const requestConfig = getRequestConfig();
    const { isFormInitialize, getFormData, formContext } = useFormInitializer<WarehouseFormData>();

    useEffect(() => {
        const endpoint = isEditMode ? `admin/warehouses/${entityId}` : 'admin/warehouses/store-data';
        const formFieldNames = isEditMode
            ? ([
                  'name',
                  'isActive',
                  'country',
                  'street',
                  'city',
                  'postalCode',
                  'description',
              ] satisfies (keyof WarehouseFormData)[])
            : [];

        getFormData(endpoint, setValue, formFieldNames);
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
            <FormApiLayout pageTitle={isEditMode ? 'Edytuj magazyn' : 'Dodaj magazyn'}>
                <WarehouseFormBody
                    control={control}
                    register={register}
                    fieldErrors={fieldErrors}
                    formContext={formContext}
                />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default WarehouseForm;
