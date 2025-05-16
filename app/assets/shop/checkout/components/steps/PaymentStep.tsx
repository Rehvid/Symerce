import React from 'react';
import { CheckoutStep } from '../../../enums/CheckoutStep';
import CheckoutSummary from './../CheckoutSummary';
import { useForm } from 'react-hook-form';
import PaymentForm from './../forms/PaymentForm';
import CheckoutFormWrapper from '../CheckoutFormWrapper';
import { createApiConfig } from '../../../../shared/api/ApiConfig';
import { HTTP_METHODS } from '../../../../admin/constants/httpConstants';
import RestApiClient from '../../../../shared/api/RestApiClient';

type Props = {
  setCurrentStep: React.Dispatch<React.SetStateAction<CheckoutStep>>;
};

type PaymentFormData = {
  paymentId: number
}

const PaymentStep: React.FC<Props> = ({ setCurrentStep }) => {
  const {
    register,
    handleSubmit,
    watch,
    formState: { errors: fieldErrors },
  } = useForm<any>({
    mode: 'onBlur',
  });


  const onSubmit = (values: PaymentFormData) => {
    const apiConfig = createApiConfig(`shop/checkout/save-payment/${values.paymentId}`, HTTP_METHODS.POST);
    apiConfig.setBody(values);

    RestApiClient().sendApiRequest(apiConfig, { onUnauthorized: null }).then(response => {
      const {errors } = response;
      if (errors.length <= 0) {
        setCurrentStep(CheckoutStep.CONFIRMATION);
      }
    });
  }

  return (
    <form className="flex flex-col gap-[1.5rem] lg:flex-row" onSubmit={handleSubmit(onSubmit)} >
      <CheckoutFormWrapper sectionTitle="Płatność">
        <PaymentForm register={register} fieldErrors={fieldErrors} inputValue={watch().payment} />
      </CheckoutFormWrapper>
      <CheckoutSummary labelButton="Przejdź do następnego kroku" onButtonClick={() => console.log('')} />
    </form>
  )
}
export default PaymentStep;
