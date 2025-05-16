import React, { ReactNode } from 'react';
import SectionStepTitle from './SectionStepTitle';

type Props = {
  children?: ReactNode;
  sectionTitle: string;
};

const CheckoutFormWrapper: React.FC<Props> = ({ children, sectionTitle }) => (
  <div className="w-full lg:flex-[2.75]">
    <SectionStepTitle title={sectionTitle} />
    {children}
  </div>
);

export default CheckoutFormWrapper;
