import React  from 'react';
import { OrderFormDataInterface } from '@admin/modules/order/interfaces/OrderFormDataInterface';
import OrderContactDetails from '@admin/modules/order/components/form/section/OrderContactDetails';
import OrderDeliveryAddress from '@admin/modules/order/components/form/section/OrderDeliveryAddress';
import OrderInvoiceAddress from '@admin/modules/order/components/form/section/OrderInvoiceAddress';
import OrderInformation from '@admin/modules/order/components/form/section/OrderInformation';
import OrderShippingAndPayment from '@admin/modules/order/components/form/section/OrderShippingAndPayment';
import OrderProduct from '@admin/modules/order/components/form/section/OrderProduct';
import { Control, FieldErrors, UseFormRegister, UseFormWatch } from 'react-hook-form';
import { FormContextInterface } from '@admin/shared/interfaces/FormContextInterface';

interface OrderFormBodyProps {
  register: UseFormRegister<OrderFormDataInterface>;
  control: Control<OrderFormDataInterface>;
  watch: UseFormWatch<OrderFormDataInterface>;
  fieldErrors: FieldErrors<OrderFormDataInterface>;
  formData?: OrderFormDataInterface;
  formContext?: FormContextInterface;
}


const OrderFormBody: React.FC<OrderFormBodyProps> = ({
 register,
 fieldErrors,
 watch,
 formData,
 formContext,
 control,
 isEditMode
}) => {

  return (
    <>
      <OrderInformation
        formData={formData}
        fieldErrors={fieldErrors}
        control={control}
        isEditMode={isEditMode}
        formContext={formContext}
      />
      <OrderContactDetails
        register={register}
        fieldErrors={fieldErrors}
      />
      <OrderDeliveryAddress
        register={register}
        fieldErrors={fieldErrors}
      />
      {watch().isInvoice && (
        <OrderInvoiceAddress
          register={register}
          fieldErrors={fieldErrors}
        />
      )}
      <OrderShippingAndPayment
        register={register}
        fieldErrors={fieldErrors}
        control={control}
        formContext={formContext}
      />
      <OrderProduct
        register={register}
        fieldErrors={fieldErrors}
        control={control}
        formContext={formContext}
      />
    </>
  );
}

export default OrderFormBody;
