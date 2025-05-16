import React, { useEffect, useState } from 'react';
import { createApiConfig } from '../../../../shared/api/ApiConfig';
import { HTTP_METHODS } from '../../../../admin/constants/httpConstants';
import RestApiClient from '../../../../shared/api/RestApiClient';
import InputRadio from '../../../common/InputRadio';
import { validationRules } from '../../../../admin/utils/validationRules';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import PlaceholderImage from '../../../../images/placeholder-image.png';

type Props = {
  register: UseFormRegister<any>;
  fieldErrors: FieldErrors;
  inputValue: any
};

type Carrier = {
  id: number,
  name: string,
  fee: string,
  deliveryTime: string,
  image?: string
}

const ShippingForm = ({ register, fieldErrors, inputValue }) => {
  const [carriers, setCarriers] = useState<Carrier[]>([]);

  useEffect(() => {
    const apiConfig = createApiConfig('shop/checkout/carriers/form-options', HTTP_METHODS.GET);
    RestApiClient().sendApiRequest(apiConfig, { onUnauthorized: null }).then(response => {
      setCarriers(response.data.carriers);
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
    <div className="flex flex-col gap-[1.5rem]">
      {carriers && carriers.length > 0 && carriers.map((carrier) => (
        <InputRadio
          key={carrier.id}
          id={`carrier-${carrier.id}`}
          value={carrier.id}
          {...register('carrierId', {
            ...validationRules.required(),
          })}
        >
          <div className="flex w-full h-full gap-5 items-center justify-between">
            <div className="flex gap-5">
              <div className="h-[100px] w-[100px]">
                {renderImage(carrier.image, carrier.name)}
              </div>
              <div className="flex flex-col gap-2">
                <span> {carrier.name}</span>
                <span>Delivery: {carrier.deliveryTime}</span>
                <span>Opłata: {carrier.fee}</span>
              </div>
            </div>
            <div className="relative">
              <span className={` ${carrier.id == inputValue ? 'border-primary' : ''} transition-all duration-300 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white`}></span>
            </div>
          </div>

        </InputRadio>
      ))}
    </div>
  );
}

export default ShippingForm;
