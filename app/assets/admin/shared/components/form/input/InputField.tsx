import React, { forwardRef, InputHTMLAttributes } from 'react';
import Error from '@admin/shared/components/Error';

interface InputFieldProps extends InputHTMLAttributes<HTMLInputElement> {
  hasError?: boolean;
  errorMessage?: string;
  icon?: React.ReactNode;
}

const InputField = forwardRef<HTMLInputElement, InputFieldProps>(
  (
    {
      type = 'text',
      hasError,
      className,
      icon,
      errorMessage,
      ...rest
    },
    ref
  ) => {



    const inputClasses = `peer w-full h-[46px] rounded-lg border border-gray-300 py-2.5 pl-[16px] pr-[60px] text-sm text-gray-800 shadow-theme-xs transition-all placeholder:text-gray-400 focus:ring-4 
    ${
      rest.disabled ? 'bg-gray-100 cursor-not-allowed ' : 'bg-white'
    }
    ${
      hasError
        ? 'border-red-500 text-red-900 focus:border-1 focus:outline-hidden focus:ring-red-100'
        : 'focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light'
    } ${className || ''}`;

    return (
      <>
        <div className="relative">
          <input
            type={type}
            ref={ref}
            className={inputClasses}
            {...rest}
          />
          {icon && <span className="absolute right-3 top-1/2 -translate-y-1/2">{icon}</span>}
        </div>
        <Error message={errorMessage}/>
      </>

    );
  }
);

InputField.displayName = 'InputField';

export default InputField;
