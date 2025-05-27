import ChevronIcon from '@/images/icons/chevron.svg';
import Heading from '@admin/components/common/Heading';
import React from 'react';

interface DetailSectionProps {
  title: string,
  children: React.ReactNode,
  useDefaultMargin: boolean,
}

const DetailSection: React.FC<DetailSectionProps> = ({ title, children, useDefaultMargin = true }) => (
  <section className={`border border-gray-100 p-4 rounded-2xl bg-white ${useDefaultMargin ? 'mt-[2rem]' : '' }`}>
    <div className="pb-4 border-b border-gray-100 flex gap-3 items-center">
      <Heading level="h3">{title}</Heading>
    </div>
    <div className='py-4 flex flex-col gap-2'>
      {children}
    </div>
  </section>
)

export default DetailSection;
