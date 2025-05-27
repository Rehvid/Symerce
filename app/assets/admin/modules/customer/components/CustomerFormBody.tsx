import CustomerDeliveryAddress from '@admin/modules/customer/components/section/CustomerDeliveryAddress';
import CustomerInvoiceAddress from '@admin/modules/customer/components/section/CustomerInvoiceAddress';
import CustomerInformation from '@admin/modules/customer/components/section/CustomerInformation';

const CustomerFormBody = ({register, fieldErrors, isEditMode, watch}) => {
  return (
    <>
      <CustomerInformation register={register} fieldErrors={fieldErrors} isEditMode={isEditMode} />
      {watch().isDelivery && (
        <CustomerDeliveryAddress register={register} fieldErrors={fieldErrors} />
      )}
      {watch().isInvoice && (
        <CustomerInvoiceAddress register={register} fieldErrors={fieldErrors} />
      )}
    </>
  )
}

export default CustomerFormBody;
