import React from 'react';
import Heading from '@/admin/components/common/Heading';

const Input = React.forwardRef(
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
            ...register
        },
        ref,
    ) => {
        const inputClasses = `peer w-full h-[46px] rounded-lg border border-gray-300 bg-white py-2.5 pl-[16px] pr-[60px] text-sm text-gray-800 shadow-theme-xs transition-all placeholder:text-gray-400 focus:ring-4 ${
            hasError
                ? 'border-red-500 text-red-900 focus:border-1 focus:outline-hidden focus:ring-red-100'
                : 'focus:border-primary focus:border-1 focus:outline-hidden  focus:ring-primary-light'
        }`;

        const labelClasses = `duration-300 block mb-2    ${hasError ? 'text-red-900 peer-focus:text-red-900' : ''}`;

        return (
            <div className={`${containerClassName || ''}`}>
                {label && (
                    <label htmlFor={id || 'input-id'} className={labelClasses}>
                        <Heading level="h4">
                            {label}
                            {isRequired && <span className="pl-1 text-red-500">*</span>}
                        </Heading>
                    </label>
                )}
                <div className="relative">
                    <input
                        className={inputClasses}
                        type={type}
                        id={id || 'input-id'}
                        value={value}
                        ref={ref}
                        placeholder={placeholder}
                        {...register}
                    />
                    {icon && <span className="absolute right-3 top-1/2 -translate-y-1/2 ">{icon}</span>}
                </div>

                {hasError && <p className="mt-2 pl-2 text-sm text-red-600">{errorMessage}</p>}
            </div>
        );
    },
);

export default Input;
