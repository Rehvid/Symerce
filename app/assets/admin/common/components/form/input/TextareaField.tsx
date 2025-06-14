import React, { FC, forwardRef, TextareaHTMLAttributes } from 'react';

interface TextareaFieldProps extends TextareaHTMLAttributes<HTMLTextAreaElement> {
    hasError?: boolean;
    errorMessage?: string;
}

const TextareaField = forwardRef<HTMLTextAreaElement, TextareaFieldProps>(
    ({ hasError, errorMessage, className, ...props }, ref) => (
        <>
      <textarea
          {...props}
          ref={ref}
          className={`
          w-full rounded-lg border p-2 transition-all focus:ring-4 focus:outline-none 
          focus:ring-primary-light focus:border-primary focus:border-1
          ${hasError ? 'border-red-500 focus:ring-red-300' : 'border-gray-300'}
          ${className ?? ''}
        `}
      />
            {hasError && errorMessage && (
                <p className="mt-1 text-sm text-red-600">{errorMessage}</p>
            )}
        </>
    )
);

TextareaField.displayName = 'TextareaField';

export default TextareaField;
