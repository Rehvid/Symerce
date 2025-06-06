import { useEffect, useState } from 'react';
import { createApiConfig } from '../../../../shared/api/ApiConfig';
import { HTTP_METHODS } from '../../../../admin/constants/httpConstants';
import RestApiClient from '../../../../shared/api/RestApiClient';
import Card from '@admin/common/components/Card';
import IconPencil from '../../../../images/icons/pencil.svg';
import { CheckoutStep } from '../../../enums/CheckoutStep';

const ConfirmationForm = ({setCurrentStep}) => {
  const [confirmationData, setConfirmationData] = useState(null);

  useEffect(() => {
    const apiConfig = createApiConfig('shop/checkout/confirmation/data', HTTP_METHODS.GET);

    RestApiClient().sendApiRequest(apiConfig, { onUnauthorized: null }).then(response => {
      setConfirmationData(response?.data?.data);
    });
  }, []);

  if (!confirmationData) return null;

  const { addressStep, carrierStep, paymentStep } = confirmationData;

  return (
    <div className="grid grid-cols-[repeat(auto-fit,minmax(250px,1fr))] gap-4 justify-items-streach">
      {addressStep && (
        <div className="flex flex-col gap-4 rounded-xl bg-background-base py-6 px-4 h-full w-full">
          <h1 className="font-semibold text-lg border-b-2 pb-3 border-gray-200 text-primary-content flex gap-4 justify-between items-center">
            <span>Adres</span>
            <IconPencil
                className="w-[24px] h-[24px] transition-all duration-300 cursor-pointer text-primary hover:text-primary-hover"
                onClick={() => setCurrentStep(CheckoutStep.ADDRESS)}
            />
          </h1>

          {/* Customer */}
          <div>
            <h3 className="text-primary-content font-semibold text-base mb-1">Klient</h3>
            <div className="flex flex-col gap-0.5 break-all">
              <span>{`${addressStep.delivery.firstname} ${addressStep.delivery.surname}`}</span>
              <span>{addressStep.delivery.email}</span>
              <span>{addressStep.delivery.phone}</span>
            </div>
          </div>

          {/* Delivery */}
          <div>
            <h3 className="text-primary-content font-semibold text-base mb-1 mt-4">Dostawa</h3>
            <div className="flex flex-wrap gap-2 break-all">
              <span>{addressStep.delivery.postalCode}</span>
              <span>{addressStep.delivery.city}</span>
              <span>{addressStep.delivery.street}</span>
            </div>
            {addressStep.delivery.deliveryInstructions && (
              <p className="text-sm mt-2">{addressStep.delivery.deliveryInstructions}</p>
            )}
          </div>

          {/* Invoice */}
          {addressStep.isInvoice && (
            <div className="mt-4">
              <h3 className="text-primary-content font-semibold text-base mb-1">Faktura</h3>
              <div className="flex flex-col gap-0.5 break-all">
                {addressStep.invoice.companyName && <span>{addressStep.invoice.companyName}</span>}
                {addressStep.invoice.companyTaxId && <span>{addressStep.invoice.companyTaxId}</span>}
              </div>
              <div className="flex flex-wrap gap-2 mt-1 break-all">
                <span>{addressStep.invoice.postalCode}</span>
                <span>{addressStep.invoice.city}</span>
                <span>{addressStep.invoice.street}</span>
              </div>
            </div>
          )}
        </div>
      )}

      {/* Carrier */}
      {carrierStep && (
        <div className="flex flex-col gap-4 rounded-xl bg-background-base py-6 px-4 h-full w-full">
          <h1 className="font-semibold text-lg border-b-2 pb-3 border-gray-200 text-primary-content flex gap-4 justify-between items-center">
            <span>Dostawa</span>
            <IconPencil
              className="w-[24px] h-[24px] transition-all duration-300 cursor-pointer text-primary hover:text-primary-hover"
              onClick={() => setCurrentStep(CheckoutStep.SHIPPING)}
            />
          </h1>
          <div className="flex flex-col gap-1 break-all">
            <span>{carrierStep.name}</span>
            <span>{carrierStep.fee}</span>
            <span>{carrierStep.deliveryTime}</span>
            {carrierStep.image && (
              <img src={carrierStep.image} alt={carrierStep.name} className="mt-2 max-w-[120px]" />
            )}
          </div>
        </div>
      )}

      {/* Payment */}
      {paymentStep && (
        <div className="flex flex-col gap-4 rounded-xl bg-background-base py-6 px-4 h-full w-full">
          <h1 className="font-semibold text-lg border-b-2 pb-2 border-gray-200 text-primary-content flex gap-4 justify-between items-center">
            <span>Płatność</span>
            <IconPencil
              className="w-[24px] h-[24px] transition-all duration-300 cursor-pointer text-primary hover:text-primary-hover"
              onClick={() => setCurrentStep(CheckoutStep.PAYMENT)}
            />
          </h1>
          <div className="flex flex-col gap-1 break-all">
            <span>{paymentStep.name}</span>
            <span>{paymentStep.fee}</span>
            {paymentStep.image && (
              <img src={paymentStep.image} alt={paymentStep.name} className="mt-2 max-w-[120px]" />
            )}
          </div>
        </div>
      )}
    </div>
  );
};

export default ConfirmationForm;
