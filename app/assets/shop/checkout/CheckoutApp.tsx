import React, { useEffect, useState, Suspense, lazy } from 'react';
import { CheckoutStep } from '../enums/CheckoutStep';
import AddressStep from './components/steps/AddressStep';
import PaymentStep from './components/steps/PaymentStep';
import ConfirmationStep from './components/steps/ConfirmationStep';
import ThankYouStep from './components/steps/ThankYouStep'
import ShippingStep from './components/steps/ShippingStep';
import CheckoutProgress from './components/CheckoutProgress';
import tableSkeleton from '@admin/common/components/skeleton/TableSkeleton';


type Props = {
  step: CheckoutStep;
};

const AddressStep      = lazy(() => import('./components/steps/AddressStep'));
const ShippingStep     = lazy(() => import('./components/steps/ShippingStep'));
const PaymentStep      = lazy(() => import('./components/steps/PaymentStep'));
const ConfirmationStep = lazy(() => import('./components/steps/ConfirmationStep'));
const ThankYouStep     = lazy(() => import('./components/steps/ThankYouStep'));

const CheckoutApp: React.FC<Props>  = ({ step }) => {
  const [currentStep, setCurrentStep] = useState<CheckoutStep>(step);

  useEffect(() => {
    setCurrentStep(step);
  }, [step]);

  useEffect(() => {
    const stepUrl = `/checkout/${currentStep}`;
    if (window.location.pathname !== stepUrl) {
      window.history.replaceState({}, '', stepUrl);
    }
  }, [currentStep]);

  useEffect(() => {
    const validSteps = Object.values(CheckoutStep);

    const onPopState = () => {
      const match = window.location.pathname.match(/\/zamowienie\/(\w+)/);
      if (match && match[1] && validSteps.includes(match[1] as CheckoutStep)) {
        setCurrentStep(match[1] as CheckoutStep);
      }
    };

    window.addEventListener('popstate', onPopState);

    return () => window.removeEventListener('popstate', onPopState);
  }, []);

  const stepComponentMap: Record<CheckoutStep, React.ReactNode> = {
    [CheckoutStep.ADDRESS]: <AddressStep setCurrentStep={setCurrentStep} />,
    [CheckoutStep.SHIPPING]: <ShippingStep setCurrentStep={setCurrentStep} />,
    [CheckoutStep.PAYMENT]: <PaymentStep setCurrentStep={setCurrentStep} />,
    [CheckoutStep.CONFIRMATION]: <ConfirmationStep setCurrentStep={setCurrentStep} />,
    [CheckoutStep.THANK_YOU]: <ThankYouStep />,
  };



  const renderSkeleton = (rows) => (
    <div className="animate-pulse space-y-6">
      {Array.from({ length: rows }, (_, i) => (
          <div key={i} className="h-6 bg-gray-200 w-full rounded"></div>
        ))
      }
    </div>
  )

  return (
    <>
      <CheckoutProgress
        currentStep={currentStep}
        onStepClick={(step) => {
          if (currentStep !== CheckoutStep.CONFIRMATION) {
            setCurrentStep(step);
          }
        }}
      />

      <Suspense fallback={renderSkeleton(16)}>
        {stepComponentMap[currentStep as CheckoutStep] ?? null}
      </Suspense>

    </>
  )
}

export default CheckoutApp;
