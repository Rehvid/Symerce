import React from 'react';

type Props = {
  labelButton: string;
  onButtonClick?: () => void;
};

const CheckoutSummary: React.FC<Props> = ({ labelButton, onButtonClick }) => (
  <div className="w-full lg:flex-[1.25] bg-background-base py-6 px-4 rounded-xl h-full">
    <h3 className="text-2xl font-semibold leading-snug border-b-2 border-gray-200 pb-4 text-primary-content">Podusmowanie</h3>
    <div className="flex flex-col gap-[1.25rem] mt-4">
      <div className="flex gap-4 items-center justify-between">
        <span>Razem</span>
        <span>Cena</span>
      </div>
      <div className="w-full mt-5">
        <button
          type="submit"
          onClick={onButtonClick}
          className="mt-[1rem] w-full text-center block px-4 py-2 bg-green-200 border border-green-200 rounded-lg transition-all duration-300 cursor-pointer hover:bg-green-300 hover:border-green-300"
        >
          {labelButton}
        </button>
      </div>
    </div>
  </div>
)

export default CheckoutSummary;
