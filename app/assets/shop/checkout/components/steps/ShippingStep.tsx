import React from 'react';
import { CheckoutStep } from '../../../enums/CheckoutStep';
import CheckoutSummary from '../CheckoutSummary';
import { useForm } from 'react-hook-form';
import ShippingForm from '../forms/ShippingForm';
import CheckoutFormWrapper from '../CheckoutFormWrapper';
import { createApiConfig } from '../../../../shared/api/ApiConfig';
import { HTTP_METHODS } from '../../../../admin/constants/httpConstants';
import RestApiClient from '../../../../shared/api/RestApiClient';

type Props = {
  setCurrentStep: React.Dispatch<React.SetStateAction<CheckoutStep>>;
};

type CarrierFormData = {
  carrierId: number
}

const ShippingStep: React.FC<Props> = ({setCurrentStep}) => {
  const {
    register,
    handleSubmit,
    watch,
    formState: { errors: fieldErrors },
  } = useForm<any>({
    mode: 'onBlur',
  });


  const onSubmit = (values: CarrierFormData) => {
    console.log(values);
    const apiConfig = createApiConfig(`shop/checkout/save-carrier/${values.carrierId}`, HTTP_METHODS.POST);
    apiConfig.setBody(values);

    RestApiClient().sendApiRequest(apiConfig, { onUnauthorized: null }).then(response => {
      const {errors } = response;
      if (errors.length <= 0) {
        setCurrentStep(CheckoutStep.PAYMENT);
      }
    });
  }

  return (
    <form className="flex flex-col gap-[1.5rem] lg:flex-row" onSubmit={handleSubmit(onSubmit)} >
      <CheckoutFormWrapper sectionTitle="Dostawa">
        <ShippingForm register={register} fieldErrors={fieldErrors} inputValue={watch().carrier} />
      </CheckoutFormWrapper>
       <CheckoutSummary labelButton="Następny krok" onButtonClick={() => console.log('clicked')} />
    </form>
  )
}

export default ShippingStep;
