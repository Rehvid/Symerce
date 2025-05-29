import React from 'react';
import PaymentMethodInformationSection from '@admin/modules/paymentMethod/components/PaymentMethodInformationSection';
import PaymentMethodConfigurationSection from '@admin/modules/paymentMethod/components/PaymentMethodConfigurationSection';

const PaymentMethodFormBody = ({register, fieldErrors, control, formData, setValue}) => (
  <>
    <PaymentMethodInformationSection
      register={register}
      fieldErrors={fieldErrors}
      formData={formData}
      setValue={setValue}
    />
    <PaymentMethodConfigurationSection
      register={register}
      fieldErrors={fieldErrors}
      control={control}
    />
  </>
)

export default PaymentMethodFormBody;
