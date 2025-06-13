import React from 'react';

interface InputLabelProps {
    htmlFor?: string;
    label?: string;
    isRequired?: boolean;
    hasError?: boolean;
}

const InputLabel: React.FC<InputLabelProps> = ({ htmlFor, label, isRequired, hasError }) => {
    if (!label) return null;

    return (
        <label className="flex items-center gap-2" htmlFor={htmlFor}>
            <span className="text-base">{label}</span>

            {isRequired && (
                <span className="bg-gray-100 border border-gray-200 inline-flex items-center text-gray-800 text-xs font-medium px-1.5 py-0.5 rounded-sm">
                    Wymagane
                </span>
            )}
        </label>
    );
};

export default InputLabel;
