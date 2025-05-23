import React from 'react';

interface DescriptionProps {
  children?: React.ReactNode;
}

const Description: React.FC<DescriptionProps> = ({children}) => {
  if (!children) return null;

  return <p className="mb-2 text-sm text-gray-500">{children}</p>;
}

export default Description;
