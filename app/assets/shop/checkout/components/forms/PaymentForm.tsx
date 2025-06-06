import SectionStepTitle from '../SectionStepTitle';
import React, { useEffect, useState } from 'react';
import { createApiConfig } from '../../../../shared/api/ApiConfig';
import { HTTP_METHODS } from '../../../../admin/constants/httpConstants';
import RestApiClient from '../../../../shared/api/RestApiClient';
import InputRadio from '../../../common/InputRadio';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import { validationRules } from '@admin/common/utils/validationRules';
import PlaceholderImage from '../../../../images/placeholder-image.png';

type Props = {
  register: UseFormRegister<any>;
  fieldErrors: FieldErrors;
  inputValue: any
};

type Payment = {
  id: number,
  name: string,
  fee: string,
  image?: string
}

const PaymentForm: React.FC<Props> = ({ register, fieldErrors, inputValue }) => {
  const [paymentMethods, setPaymentMethods] = useState<Payment[]>([]);

  useEffect(() => {
    const apiConfig = createApiConfig('shop/checkout/payment/form-options', HTTP_METHODS.GET);
    RestApiClient().sendApiRequest(apiConfig, { onUnauthorized: null }).then(response => {
      setPaymentMethods(response.data.paymentMethods);
    });
  }, []);

  const renderImage = (image: any, name: any) => {

    if (!image) {
      return (
        <div className="w-full pb-[100%] relative">
          <img
            className="absolute inset-0 w-full h-full object-cover rounded-xl"
            src={PlaceholderImage}
            alt={`Placeholder Image - ${name}`}
            loading="lazy"
          />
        </div>
      )
    }

    return (
      <div className="w-full pb-[100%] relative">
        <img
          className="absolute inset-0 w-full h-full object-cover rounded-xl"
          src={image}
          alt={`Image - ${name}`}
          loading="lazy"
        />
      </div>
    )
  }

  return (
    <>
      <div className="flex flex-col gap-[1.5rem]">
        {paymentMethods && paymentMethods.length > 0 && paymentMethods.map((payment) => (
          <InputRadio
            key={payment.id}
            id={`payment-${payment.id}`}
            value={payment.id}
            {...register('paymentId', {
              ...validationRules.required(),
            })}
          >
            <div className="flex w-full h-full gap-5 items-center justify-between">
              <div className="flex gap-5">
                <div className="h-[100px] w-[100px]">
                  {renderImage(payment.image, payment.name)}
                </div>
                <div className="flex flex-col gap-2">
                  <span> {payment.name}</span>
                  <span>Opłata: {payment.fee}</span>
                </div>
              </div>
              <div className="relative">
                <span className={` ${payment.id == inputValue ? 'border-primary' : ''} transition-all duration-300 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white`}></span>
              </div>
            </div>

          </InputRadio>
        ))}
      </div>

    </>
  )
};

export default PaymentForm;
