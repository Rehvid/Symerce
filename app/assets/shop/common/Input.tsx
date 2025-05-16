import React from 'react';

export type InputProps = {
  id?: string;
  type?: string;
  value?: string;
  label?: string;
  hasError?: boolean;
  errorMessage?: string;
  containerClassName?: string;
  icon?: React.ReactNode;
  isRequired?: boolean;
  placeholder?: string;
} & React.InputHTMLAttributes<HTMLInputElement>;

const Input = React.forwardRef<HTMLInputElement, InputProps>(
  (
    {
      id,
      type = 'text',
      value,
      label,
      hasError,
      errorMessage,
      containerClassName,
      icon,
      isRequired,
      placeholder = '',
      ...rest
    },
    ref
  ) => {
    const inputClasses = `w-full h-[46px] rounded-lg border border-gray-300 bg-white py-2.5 pl-[16px] pr-[60px] text-sm text-gray-800 shadow-theme-xs transition-all placeholder:text-gray-400  ${
      hasError
        ? 'border-red-500 text-red-900 focus:border-1 focus:outline-hidden focus:ring-red-100'
        : 'focus:border-primary active:border-primary focus:outline-hidden'
    }`;

    const labelClasses = `duration-300 block mb-2 ${hasError ? 'text-red-900 peer-focus:text-red-900' : ''}`;

    return (
      <div className={`${containerClassName || ''}`}>
        {label && (
          <label htmlFor={id || 'input-id'} className={labelClasses}>
            <h1>
              {label}
              {isRequired && <span className="pl-1 text-red-500">*</span>}
            </h1>
          </label>
        )}
        <div>
          <input
            className={inputClasses}
            type={type}
            id={id || 'input-id'}
            value={value}
            ref={ref}
            placeholder={placeholder}
            {...rest}
          />
          {icon && <span className="absolute right-3 top-1/2 -translate-y-1/2">{icon}</span>}
        </div>

        {hasError && <p className="mt-2 pl-2 text-sm text-red-600">{errorMessage}</p>}
      </div>
    );
  }
);

Input.displayName = 'Input';

export default Input;
