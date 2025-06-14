import React, { FC, forwardRef, TextareaHTMLAttributes } from 'react';

interface TextareaFieldProps extends TextareaHTMLAttributes<HTMLTextAreaElement> {}

const TextareaField = forwardRef<HTMLTextAreaElement, TextareaFieldProps>((props, ref) => (
    <textarea
        {...props}
        ref={ref}
        className="w-full rounded-lg border border-gray-300 p-2 transition-all focus:ring-4 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light"
    />
));

TextareaField.displayName = 'TextareaField';

export default TextareaField;
