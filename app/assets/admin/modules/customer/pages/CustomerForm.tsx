import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import CustomerFormBody from '@admin/modules/customer/components/CustomerFormBody';
import { CustomerFormData } from '@admin/modules/customer/interfaces/CustomerFormData';

const CustomerForm = () => {
    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/customers',
        redirectSuccessUrl: '/admin/customers',
    });
    const requestConfig = getRequestConfig();
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        control,
        formState: { errors: fieldErrors },
    } = useForm<CustomerFormData>({
        mode: 'onBlur',
        defaultValues: {
            id: entityId,
        },
    });

    const { isFormInitialize, getFormData, formContext } = useFormInitializer<CustomerFormData>();

    useEffect(() => {
        const endpoint = isEditMode ? `admin/customers/${entityId}` : `admin/customers/store-data`;
        const formFieldNames = isEditMode
            ? ([
                  'firstname',
                  'surname',
                  'email',
                  'phone',
                  'isActive',
                  'isDelivery',
                  'isInvoice',
                  'street',
                  'postalCode',
                  'city',
                  'countryId',
                  'deliveryInstructions',
                  'invoiceStreet',
                  'invoicePostalCode',
                  'invoiceCompanyName',
                  'invoiceCompanyTaxId',
                  'invoiceCity',
                  'invoiceCountryId',
              ] satisfies (keyof CustomerFormData)[])
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
            <FormApiLayout pageTitle={isEditMode ? 'Edytuj klienta' : 'Dodaj klienta'}>
                <CustomerFormBody
                    register={register}
                    fieldErrors={fieldErrors}
                    isEditMode={isEditMode}
                    control={control}
                    formContext={formContext}
                />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default CustomerForm;
