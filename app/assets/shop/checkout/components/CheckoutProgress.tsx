import React from 'react';
import { CheckoutStep } from '../../enums/CheckoutStep';

type Props = {
  currentStep: CheckoutStep;
  onStepClick?: (step: CheckoutStep) => void;
};

const steps: { key: CheckoutStep; label: string }[] = [
  { key: CheckoutStep.ADDRESS, label: 'Adres' },
  { key: CheckoutStep.SHIPPING, label: 'Dostawa' },
  { key: CheckoutStep.PAYMENT, label: 'Płatność' },
  { key: CheckoutStep.CONFIRMATION, label: 'Potwierdzenie' },
];

const Icon = ({
  isActive,
  isVisited,
  index,
}: {
  isActive: boolean;
  isVisited: boolean;
  index: number;
}) => {
  const baseClasses =
    'w-6 h-6 lg:w-10 lg:h-10 rounded-full flex justify-center items-center mx-auto mb-3 text-sm lg:text-base font-medium';
  const activeClasses = 'bg-indigo-600 text-white border-transparent';
  const visitedClasses = 'bg-indigo-50 text-indigo-600 border-indigo-600';
  const defaultClasses = 'bg-gray-50 text-gray-500 border-gray-200';

  return (
    <span
      className={`${baseClasses} border-2 ${
        isActive ? activeClasses : isVisited ? visitedClasses : defaultClasses
      }`}
    >
      {index + 1}
    </span>
  );
};

const CheckoutProgress: React.FC<Props> = ({ currentStep, onStepClick }) => {
  const currentIndex = steps.findIndex((s) => s.key === currentStep);

  return (
    <nav className="flex items-center justify-between sm:px-8 py-6 bg-white">
      {steps.map((step, index) => {
        const isActive = index === currentIndex;
        const isVisited = index < currentIndex;

        return (
          <div className="flex-1 flex items-center" key={step.key}>
            <div className="flex flex-col items-center text-center w-full relative">
              <button
                type="button"
                disabled={!isVisited && !isActive}
                onClick={() => onStepClick?.(step.key)}
                className={`focus:outline-none flex flex-col items-center z-[3] ${isVisited || isActive ? 'cursor-pointer' : ''}`}
              >
                <Icon isActive={isActive} isVisited={isVisited} index={index} />
                <span
                  className={`text-xs sm:text-sm ${
                    isActive
                      ? 'text-indigo-600 font-semibold'
                      : isVisited
                        ? 'text-gray-900'
                        : 'text-gray-400'
                  }`}
                >
                  {step.label}
                </span>
              </button>

              {/* Line to next step */}
              {index < steps.length - 1 && (
                <div className="absolute w-full h-0.5 top-3 lg:top-5 left-1/2 translate-x-0 z-[2]">
                  <div
                    className={`h-0.5 w-full ${
                      isVisited ? 'bg-indigo-600' : 'bg-gray-200'
                    }`}
                  />
                </div>
              )}
            </div>
          </div>
        );
      })}
    </nav>
  );
};

export default CheckoutProgress;
