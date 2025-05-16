import React from 'react';
import { CheckoutStep } from '../../../enums/CheckoutStep';
import { useForm } from 'react-hook-form';
import CheckoutSummary from '../CheckoutSummary';
import ConfirmationForm from '../forms/ConfirmationForm';
import CheckoutFormWrapper from '../CheckoutFormWrapper';

type Props = {
  setCurrentStep: React.Dispatch<React.SetStateAction<CheckoutStep>>;
};


const ConfirmationStep: React.FC<Props>  = ({setCurrentStep}) => {
  const {
    handleSubmit,
  } = useForm<any>({
    mode: 'onBlur',
  });

  const onSubmit = (values: any) => {
    window.location.replace('/thank-you');
  }

  return (
    <form className="flex flex-col gap-[1.5rem] lg:flex-row" onSubmit={handleSubmit(onSubmit)} >
      <CheckoutFormWrapper sectionTitle="Potwierdzenie">
        <ConfirmationForm setCurrentStep={setCurrentStep} />
      </CheckoutFormWrapper>
      <CheckoutSummary labelButton="Przejdź do następnego kroku" onButtonClick={() => console.log('')} />
    </form>
  )
}
export default ConfirmationStep;
