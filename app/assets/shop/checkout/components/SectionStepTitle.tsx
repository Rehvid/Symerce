import React from 'react';

type Props = {
  title: string
}

const SectionStepTitle: React.FC<Props> = ({title}) => (
  <h1 className="text-2xl font-semibold leading-snug text-primary-content mb-[2rem] border-b-2 border-gray-200 py-4">
    {title}
  </h1>
)

export default SectionStepTitle;
