import React, { useEffect, useState } from 'react';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import OrderContactDetails from '@admin/modules/order/components/form/section/OrderContactDetails';
import OrderDeliveryAddress from '@admin/modules/order/components/form/section/OrderDeliveryAddress';
import OrderInvoiceAddress from '@admin/modules/order/components/form/section/OrderInvoiceAddress';
import OrderInformation from '@admin/modules/order/components/form/section/OrderInformation';
import OrderShippingAndPayment from '@admin/modules/order/components/form/section/OrderShippingAndPayment';
import OrderProduct from '@admin/modules/order/components/form/section/OrderProduct';
import { Control, FieldErrors, UseFormRegister, UseFormSetValue, useWatch } from 'react-hook-form';
import { OrderFormContext } from '@admin/modules/order/interfaces/OrderFormContext';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { OrderDetail as OrderDetailInterface } from '@admin/modules/order/interfaces/OrderDetail';
import { useAdminApi } from '@admin/common/context/AdminApiContext';

interface OrderFormBodyProps {
    register: UseFormRegister<OrderFormData>;
    control: Control<OrderFormData>;
    fieldErrors: FieldErrors<OrderFormData>;
    formData?: OrderFormData;
    formContext: OrderFormContext;
    isEditMode: boolean;
    setValue: UseFormSetValue<OrderFormData>
}

const OrderFormBody: React.FC<OrderFormBodyProps> = ({
    register,
    fieldErrors,
    formData,
    formContext,
    control,
    isEditMode,
    setValue,
}) => {
    const { handleApiRequest } = useAdminApi();
    const isInvoice = useWatch({ control, name: 'isInvoice' });
    const useCustomer = useWatch({control, name: 'useCustomer'});
    const customerId = useWatch({control, name: "customerId"});
    const [isInsertingCustomerData, setIsInsertingCustomerData] = useState<boolean>(false);
    const [isInitialDataLoaded, setIsInitialDataLoaded] = useState<boolean>(false);

    useEffect(() => {
        setIsInitialDataLoaded(true);
    }, []);

    useEffect(() => {
        if (!isInitialDataLoaded) return;
        if (useCustomer) {
            if (customerId) {
                fetchDetails().catch(error => console.error(error));
            }
            return;
        }

        setValue('customerId', 0);
        setIsInsertingCustomerData(true);
        fillDataFromCustomer(false);
    }, [useCustomer, customerId]);

    const fetchDetails = async () => {
        setIsInsertingCustomerData(true);
        await handleApiRequest(HttpMethod.GET, `admin/orders/${6}/customer-details`, {
            onSuccess: ({ data }) => {
                fillDataFromCustomer(true, data as OrderFormData);
            },
        });
    };

    const fillDataFromCustomer = (useCustomer: boolean, customerData?: OrderFormData | null) => {
        setValue('email', useCustomer ? customerData?.email : '');
        setValue('firstname', useCustomer ? customerData?.firstname : '');
        setValue('surname', useCustomer ? customerData?.surname : '');
        setValue('phone', useCustomer ? customerData?.phone : '');
        setValue('street', useCustomer ? customerData?.street ?? '' : '');
        setValue('postalCode', useCustomer ? customerData?.postalCode ?? '' : '');
        setValue('city', useCustomer ? customerData?.city ?? '' : '');
        setValue('countryId', useCustomer ? customerData?.countryId ?? 0 : 0);
        setValue('deliveryInstructions', useCustomer ? customerData?.deliveryInstructions  : '');
        setValue('isInvoice', useCustomer ? customerData?.isInvoice ?? false : false);
        setValue('invoiceStreet', useCustomer ? customerData?.invoiceStreet ?? '' : '');
        setValue('invoiceCompanyName', useCustomer ? customerData?.invoiceCompanyName ?? '' : '');
        setValue('invoicePostalCode', useCustomer ? customerData?.invoicePostalCode ?? '' : '');
        setValue('invoiceCity', useCustomer ? customerData?.invoiceCity ?? '' : '');
        setValue('invoiceCompanyTaxId', useCustomer ? customerData?.invoiceCompanyTaxId ?? '' : '');
        setValue('invoiceCountryId', useCustomer ? customerData?.invoiceCountryId ?? 0 : 0);

        setIsInsertingCustomerData(false);
    }

    return (
        <>
            <OrderInformation
                formData={formData}
                fieldErrors={fieldErrors}
                control={control}
                isEditMode={isEditMode}
                formContext={formContext}
                register={register}
                useCustomer={useCustomer}
            />
            {isInsertingCustomerData ? (
                <FormSkeleton rowsCount={36} />
            ) : (
                <>
                    <OrderContactDetails register={register} fieldErrors={fieldErrors} />
                    <OrderDeliveryAddress
                        register={register}
                        fieldErrors={fieldErrors}
                        formContext={formContext}
                        control={control}
                    />
                    {isInvoice && (
                        <OrderInvoiceAddress
                            register={register}
                            fieldErrors={fieldErrors}
                            formContext={formContext}
                            control={control}
                        />
                    )}
                </>
            )}
            <OrderShippingAndPayment control={control} formContext={formContext} />
            <OrderProduct register={register} fieldErrors={fieldErrors} control={control} formContext={formContext} />
        </>
    );
};

export default OrderFormBody;
