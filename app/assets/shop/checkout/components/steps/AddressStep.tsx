import React, { useState } from 'react';
import { CheckoutStep } from '../../../enums/CheckoutStep';
import { useForm } from 'react-hook-form';
import AddressDeliveryForm from './../forms/AddressDeliveryForm';
import AddressInvoiceForm from './../forms/AddressInvoiceForm';
import Switch from '../../../common/Switch';
import CheckoutSummary from './../CheckoutSummary';
import { createApiConfig } from '../../../../shared/api/ApiConfig';
import { HTTP_METHODS } from '../../../../admin/constants/httpConstants';
import RestApiClient from '../../../../shared/api/RestApiClient';
import CheckoutFormWrapper from '../CheckoutFormWrapper';

type Props = {
  setCurrentStep: React.Dispatch<React.SetStateAction<CheckoutStep>>;
};

export type CheckoutFormData = {
  firstname: string;
  surname: string;
  phoneNumber: string;
  street: string;
  postalCode: string;
  city: string;
  deliveryInstructions?: string;
  useInvoiceAddress: boolean,
  invoicePhoneNumber?: string;
  invoiceStreet?: string;
  invoicePostalCode?: string;
  invoiceCity?: string;
  invoiceCompanyName?: string
  invoiceCompanyTaxId?: string
};

const AddressStep: React.FC<Props> = ({ setCurrentStep }) => {
  const [showInvoiceForm, setShowInvoiceForm] = useState<boolean>(false);

  const {
    register,
    handleSubmit,
    formState: { errors: fieldErrors },
  } = useForm<CheckoutFormData>({
    mode: 'onBlur',
  });


  const onSubmit = (values: CheckoutFormData) => {
    values.useInvoiceAddress = showInvoiceForm;

    const apiConfig = createApiConfig('shop/checkout/save-address', HTTP_METHODS.POST);
    apiConfig.setBody(values);

    RestApiClient().sendApiRequest(apiConfig, { onUnauthorized: null }).then(response => {
      const {errors } = response;
      if (errors.length <= 0) {
        setCurrentStep(CheckoutStep.SHIPPING);
      }
    });
  }

 return (
   <form className="flex flex-col gap-[1.5rem] lg:flex-row" onSubmit={handleSubmit(onSubmit)} >
     <CheckoutFormWrapper sectionTitle="Adres">
       <AddressDeliveryForm register={register} fieldErrors={fieldErrors} />

       <Switch
         label="Dodaj fakture"
         checked={showInvoiceForm}
         onChange={(e: React.ChangeEvent<HTMLInputElement>) => setShowInvoiceForm(e.target.checked)}
       />

       {showInvoiceForm && (
         <div className="mt-[2rem]">
           <AddressInvoiceForm register={register} fieldErrors={fieldErrors} />
         </div>
       )}
     </CheckoutFormWrapper>
     <CheckoutSummary labelButton="Przejdź do następnego kroku" onButtonClick={() => console.log('')} />
   </form>
 )
}

export default AddressStep;
