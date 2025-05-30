import CustomerDeliveryAddress from '@admin/modules/customer/components/section/CustomerDeliveryAddress';
import CustomerInvoiceAddress from '@admin/modules/customer/components/section/CustomerInvoiceAddress';
import CustomerInformation from '@admin/modules/customer/components/section/CustomerInformation';

const CustomerFormBody = ({register, fieldErrors, isEditMode, watch, control, formData, formContext}) => {
  return (
    <>
      <CustomerInformation register={register} fieldErrors={fieldErrors} isEditMode={isEditMode} />
      {watch().isDelivery && (
        <CustomerDeliveryAddress register={register} fieldErrors={fieldErrors} control={control} formData={formData} formContext={formContext} />
      )}
      {watch().isInvoice && (
        <CustomerInvoiceAddress register={register} fieldErrors={fieldErrors}  control={control} formData={formData} formContext={formContext} />
      )}
    </>
  )
}

export default CustomerFormBody;
