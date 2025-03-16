import React from "react";

const Input = React.forwardRef(
    (
        {
            id,
            type,
            value,
            placeholder,
            label,
            hasError,
            errorMessage,
            ...register
        },
        ref
    ) => {
    const inputClasses = `bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ${
        hasError
            ? "border-red-500 text-red-900 placeholder-red-700 bg-red-50 focus:ring-red-500 focus:border-red-500 outline-red-500"
            : "border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500"
    }`;

    const labelClasses = `block text-sm/6 font-medium  ${
        hasError ? "text-red-700" : "text-gray-900"
    }`;

    return (
        <div className="mb-6">
            <label htmlFor={id}  className={labelClasses}>{label}</label>
            <input
                className={inputClasses}
                type={type}
                id={id}
                placeholder={placeholder}
                value={value}
                ref={ref}
                {...register}
            />
            {hasError && (
                <p className="mt-2 text-sm text-red-600 dark:text-red-500">{errorMessage}</p>
            )}
        </div>
    )
})

export default Input;
