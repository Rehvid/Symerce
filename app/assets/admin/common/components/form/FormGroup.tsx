import React from 'react';

interface FormGroupProps {
  label: React.ReactNode;
  children: React.ReactNode;
  description?: React.ReactNode;
}

const FormGroup: React.FC<FormGroupProps> = ({label, description, children, additionalClasses = ''}) => {
  return (
    <div className={`flex flex-col items-start lg:flex-row ${additionalClasses}`}>
      <div className="w-full lg:mr-10 lg:w-64">
        {label}
        {description && <div className="mt-4">{description}</div>}
      </div>
      <div className="mt-4 w-full flex-1 lg:mt-0">
        {children}
      </div>
    </div>
  )
}

export default FormGroup;
