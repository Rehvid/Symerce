import React from 'react';

const AppInput = React.forwardRef(
    (
        { id, type = 'text', value, label, hasError, errorMessage, containerClassName, icon, isRequired, ...register },
        ref,
    ) => {
        const inputClasses = `peer w-full h-[46px] rounded-full border border-gray-300 bg-white py-2.5 pl-[40px] pr-[60px] text-sm text-gray-800 shadow-theme-xs transition-all placeholder:text-gray-400 focus:ring-4 ${
            hasError
                ? 'border-red-500 text-red-900 focus:border-1 focus:outline-hidden focus:ring-red-100'
                : 'focus:border-primary focus:border-1 focus:outline-hidden  focus:ring-primary-light'
        }`;

        const labelClasses = `absolute text-sm text-gray-500 px-2 bg-white duration-300 transform -translate-y-5.5 top-3.25 scale-[90%] z-10 origin-[0] start-2.5 peer-placeholder-shown:scale-100 peer-focus:scale-[90%] peer-focus:text-blue-600  peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-5.5 ${
            hasError ? 'text-red-900 peer-focus:text-red-900' : ''
        }`;

        return (
            <div className={`relative ${containerClassName || ''}`}>
                {icon && <span className="absolute right top-2.75 right-0 pr-4">{icon}</span>}

                <input
                    className={inputClasses}
                    type={type}
                    id={id || 'input-id'}
                    value={value}
                    ref={ref}
                    placeholder={' '}
                    {...register}
                />
                {label && (
                    <label htmlFor={id || 'input-id'} className={labelClasses}>
                        {label}
                        {isRequired && <span className="pl-1 text-red-500">*</span>}
                    </label>
                )}
                {hasError && <p className="mt-2 pl-2 text-sm text-red-600">{errorMessage}</p>}
            </div>
        );
    },
);

export default AppInput;
