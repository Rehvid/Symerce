import { useForm } from 'react-hook-form';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import { useEffect } from 'react';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import PaymentMethodFormBody from '@admin/modules/paymentMethod/components/PaymentMethodFormBody';
import { PaymentMethodFormData } from '@admin/modules/paymentMethod/interfaces/PaymentMethodFormData';

const PaymentMethodForm = () => {
    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/payment-methods',
        redirectSuccessUrl: '/admin/payment-methods',
    });
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        control,
        formState: { errors: fieldErrors },
    } = useForm<PaymentMethodFormData>({
        mode: 'onBlur',
        defaultValues: {
            id: entityId
        }
    });
    const requestConfig = getRequestConfig();

    const { isFormInitialize, getFormData, formData } = useFormInitializer<PaymentMethodFormData>();

    useEffect(() => {
        if (isEditMode) {
            getFormData(`admin/payment-methods/${entityId}`, setValue, [
                'name',
                'isActive',
                'code',
                'fee',
                'isRequireWebhook',
                'config',
            ] satisfies (keyof PaymentMethodFormData)[]);
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
            <FormApiLayout pageTitle={isEditMode ? 'Edytuj metodę płatności' : 'Dodaj metodę płatności'}>
                <PaymentMethodFormBody
                    register={register}
                    fieldErrors={fieldErrors}
                    control={control}
                    formData={formData}
                    setValue={setValue}
                />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default PaymentMethodForm;
